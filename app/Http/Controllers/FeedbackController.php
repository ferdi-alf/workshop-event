<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Workshop;
use App\Models\FeedbackQuestion;
use App\Models\FeedbackOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use function Laravel\Prompts\alert;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback');
    }

    public function searchWorkshops(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
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
        $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string|max:500',
            'questions.*.type' => 'required|in:free_text,multiple_choice',
            'questions.*.options' => 'array',
            'questions.*.options.*' => 'required_if:questions.*.type,multiple_choice|string|max:255',
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

            return redirect()->route('feedback.index')->with(AlertHelper::success('Feedback berhasil disimpan.', 'Sukses'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(AlertHelper::error('Terjadi kesalahan: ' . $e->getMessage(), 'Error'))->withInput();
        }
    }
}