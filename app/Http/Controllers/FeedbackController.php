<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\FeedbackAnswer;
use App\Models\Workshop;
use App\Models\FeedbackQuestion;
use App\Models\FeedbackOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback');
    }

    public function getPage($slug)
    {
        $workshop = Workshop::all()->first(function($w) use ($slug) {
            return Str::slug($w->title) === $slug;
        });

        if (!$workshop) {
            abort(404);
        }

        if ($workshop->status !== 'finished') {
            return redirect()->route('welcome')->with(AlertHelper::error('Workshop ini belum selesai. Feedback hanya dapat diberikan setelah workshop selesai.', 'Error'));
        }

        $feedbackQuestions = $workshop->feedbackQuestions()->with('options')->get();

        if ($feedbackQuestions->isEmpty()) {
            return redirect()->route('welcome')->with(AlertHelper::info('Belum ada pertanyaan feedback yang tersedia untuk workshop ini.', 'Info'));
        }

        return view('feedback-form', compact('workshop', 'feedbackQuestions'));
    }

    public function storeFeedbackByUser(Request $request, $slug)
    {
        $workshop = Workshop::all()->first(function($w) use ($slug) {
            return Str::slug($w->title) === $slug;
        });

        if (!$workshop) {
            abort(404);
        }

        if ($workshop->status !== 'finished') {
            return redirect()->route('welcome')->with(AlertHelper::error('Workshop ini belum selesai. Feedback hanya dapat diberikan setelah workshop selesai.', 'Error'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'answers' => 'required|array',
            'answers.*' => 'required'
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'answers.required' => 'Semua pertanyaan wajib dijawab',
            'answers.*.required' => 'Jawaban tidak boleh kosong'
        ]);

        try {
            foreach ($validated['answers'] as $questionId => $answer) {
                $question = FeedbackQuestion::find($questionId);
                
                if (!$question || $question->workshop_id !== $workshop->id) {
                    continue;
                }

                $feedbackAnswer = new FeedbackAnswer([
                    'question_id' => $questionId,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'whatsapp' => $validated['whatsapp']
                ]);

                if ($question->type === 'multiple_choice') {
                    $feedbackAnswer->option_id = $answer;
                } else {
                    $feedbackAnswer->answer_text = $answer;
                }

                $feedbackAnswer->save();
            }

            return redirect()->route('welcome')->with(AlertHelper::success('Terima kasih! Feedback Anda telah berhasil dikirim.', 'Berhasil'));

        } catch (\Exception $e) {
            return back()->withInput()->with(AlertHelper::error('Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.', 'Error'));
        }
    }


    public function searchWorkshops(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            Log::info($query);
            return response()->json([]);
        }

        $workshops = Workshop::where('title', 'LIKE', '%' . $query . '%')
            ->select('id', 'title')
            ->limit(10)
            ->get();

        return response()->json($workshops);
    }

    public function store(Request $request) 
    {
        // dd($request->all());
        $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string|max:500',
            'questions.*.type' => 'required|in:free_text,multiple_choice',
            'questions.*.options' => 'nullable|array', 
            'questions.*.options.*' => 'required_if:questions.*.type,multiple_choice|nullable|string|max:255',
        ]);

        try {
            foreach ($request->questions as $questionData) {
                $question = FeedbackQuestion::create([
                    'workshop_id' => $request->workshop_id,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                ]);

                if ($questionData['type'] === 'multiple_choice' && !empty($questionData['options'])) {
                    foreach ($questionData['options'] as $optionText) {
                        if (!empty(trim($optionText))) {
                            FeedbackOption::create([
                                'question_id' => $question->id,
                                'option_text' => trim($optionText),
                            ]);
                        }
                    }
                }
            }

            $feedBackRating = FeedbackQuestion::where('workshop_id', $request->workshop_id)
                ->where('type', 'rating')
                ->first();

            if (!$feedBackRating) {
                FeedbackQuestion::create([
                    'workshop_id' => $request->workshop_id,
                    'question' => 'Berapakah rating yang kamu berikan untuk workshop ini',
                    'type' => 'rating',
                ]);
            }

            return redirect()->route('feedback.index')
                ->with(AlertHelper::success('Feedback berhasil disimpan.', 'Sukses'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(AlertHelper::error('Terjadi kesalahan: ' . $e->getMessage(), 'Error'))
                ->withInput();
        }
    }

}