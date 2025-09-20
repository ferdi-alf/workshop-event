<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\FeedbackQuestion;
use App\Models\Workshop;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class WorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::with(['participants', 'feedbackQuestions'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($workshop) {
                return [
                    'id' => $workshop->id,
                    'title' => $workshop->title,
                    'description' => $workshop->description,
                    'date' => $workshop->date,
                    'time_start' => $workshop->time_start,
                    'time_end' => $workshop->time_end,
                    'location' => $workshop->location,
                    'benefit' => $workshop->benefit,
                    'quota' => $workshop->quota,
                    'status' => $workshop->status,
                    'participant_count' => $workshop->participants->count(),
                    'remaining_quota' => $workshop->remaining_quota,
                    'formatted_date' => Carbon::parse($workshop->date)->format('d M Y'),
                    'formatted_time' => Carbon::parse($workshop->time_start)->format('H:i') . ' - ' . Carbon::parse($workshop->time_end)->format('H:i'),
                ];
            });


        return view('workshop', compact('workshops'));
    }

    public function show($id)
    {
        try {
            $workshop = Workshop::with(['participants', 'feedbackQuestions'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $workshop->id,
                    'title' => $workshop->title,
                    'description' => $workshop->description,
                    'date' => $workshop->date,
                    'time_start' => $workshop->time_start,
                    'time_end' => $workshop->time_end,
                    'location' => $workshop->location,
                    'benefit' => $workshop->benefit,
                    'quota' => $workshop->quota,
                    'status' => $workshop->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Workshop tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'time_start'  => 'required',
            'time_end'    => 'required',
            'location'    => 'required|string|max:255',
            'benefit'     => 'required|string',
            'quota'       => 'required|integer',
            'status'      => 'required|string|in:,inactive,registered,finished',
        ]);

        if ($request->status === 'registered') {
            $exists = Workshop::where('status', 'registered')->exists();
            if ($exists) {
                return redirect()->back()->with(AlertHelper::error('Sudah ada workshop dengan status registered', 'Error'));
            }
        }

        Workshop::create($request->all());

        return redirect()->back()->with(AlertHelper::success('User berhasil ditambahkan', 'Success'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'time_start'  => 'required',
            'time_end'    => 'required',
            'location'    => 'required|string|max:255',
            'benefit'     => 'required|string',
            'quota'       => 'required|integer',
            'status'      => 'required|string|in:,inactive,registered,finished',
        ]);

        $workshop = Workshop::findOrFail($id);

        if ($request->status === 'registered') {
            $exists = Workshop::where('status', 'registered')
                ->where('id', '!=', $id)
                ->exists();
            if ($exists) {
                return redirect()->back()->with(AlertHelper::error('Sudah ada workshop dengan status registered', 'Error'));
            }
        }

        $workshop->update($request->all());

        return redirect()->back()->with(AlertHelper::success('User berhasil diupdate', 'Success'));
    }

    public function destroy($id)
    {
        $workshop = Workshop::find($id);

        if (!$workshop) {
            return redirect()->back()->with(AlertHelper::error('User tidak ditemukan', 'Error'));
        }

        try {
            $workshop->delete();
            return redirect()->back()->with(AlertHelper::success('User berhasil dihapus', 'Success'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertHelper::error('Gagal menghapus user', 'Error'));
        }
    }


    public function getParticipants($id)
    {
        try {
            $workshop = Workshop::with('participants')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $workshop->participants
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Workshop tidak ditemukan'
            ], 404);
        }
    }

    public function getFeedbackQuestions($id)
    {
        try {
            $workshop = Workshop::with('feedbackQuestions.options')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $workshop->feedbackQuestions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Workshop tidak ditemukan'
            ], 404);
        }
    }

    public function getAnalytics($id)
    {
        try {
            $workshop = Workshop::findOrFail($id);
            
            $questions = FeedbackQuestion::where('workshop_id', $id)
                ->whereIn('type', ['multiple_choice', 'rating'])
                ->with(['options', 'answers.option'])
                ->get();

            $analytics = [];

            foreach ($questions as $question) {
                if ($question->type === 'multiple_choice') {
                    $optionCounts = [];
                    $totalAnswers = $question->answers->count();

                    foreach ($question->options as $option) {
                        $count = $question->answers->where('option_id', $option->id)->count();
                        $optionCounts[] = [
                            'label' => $option->option_text,
                            'value' => $count,
                            'percentage' => $totalAnswers > 0 ? round(($count / $totalAnswers) * 100, 1) : 0
                        ];
                    }

                    $chartType = count($question->options) <= 5 ? 'horizontal_bar' : 'pie';

                    $analytics[] = [
                        'question' => $question->question,
                        'type' => $question->type,
                        'chart_type' => $chartType,
                        'data' => $optionCounts,
                        'total_responses' => $totalAnswers
                    ];
                } elseif ($question->type === 'rating') {
                    $ratingCounts = [];
                    $ratings = $question->answers->pluck('answer_text')->filter()->map(function($rating) {
                        return (int) $rating;
                    });

                    for ($i = 1; $i <= 5; $i++) {
                        $count = $ratings->filter(function($rating) use ($i) {
                            return $rating === $i;
                        })->count();
                        
                        $ratingCounts[] = [
                            'label' => "Rating $i",
                            'value' => $count,
                            'percentage' => $ratings->count() > 0 ? round(($count / $ratings->count()) * 100, 1) : 0
                        ];
                    }

                    $analytics[] = [
                        'question' => $question->question,
                        'type' => $question->type,
                        'chart_type' => 'horizontal_bar',
                        'data' => $ratingCounts,
                        'total_responses' => $ratings->count(),
                        'average_rating' => $ratings->count() > 0 ? round($ratings->avg(), 1) : 0
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'workshop' => $workshop,
                    'analytics' => $analytics
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data analytics tidak dapat dimuat',
                'error' => $e->getMessage()
            ], 500);
        }
    }





public function downloadPDF($id)
{
    try {
        $workshop = Workshop::with(['participants', 'feedbackQuestions.options', 'feedbackQuestions.answers.option'])
            ->findOrFail($id);
        
        $questions = FeedbackQuestion::where('workshop_id', $id)
            ->whereIn('type', ['multiple_choice', 'rating'])
            ->with(['options', 'answers.option'])
            ->get();
            
        $analytics = [];
        
        foreach ($questions as $index => $question) {
            if ($question->type === 'multiple_choice') {
                $optionCounts = [];
                $totalAnswers = $question->answers->count();
                
                foreach ($question->options as $option) {
                    $count = $question->answers->where('option_id', $option->id)->count();
                    $percentage = $totalAnswers > 0 ? round(($count / $totalAnswers) * 100, 1) : 0;
                    
                    $optionCounts[] = [
                        'label' => $option->option_text,
                        'value' => $count,
                        'percentage' => $percentage
                    ];
                }
                
                // Sort by percentage descending untuk tampilan yang lebih baik
                usort($optionCounts, function($a, $b) {
                    return $b['percentage'] <=> $a['percentage'];
                });
                
                $analytics[] = [
                    'question' => $question->question,
                    'type' => $question->type,
                    'chart_type' => count($question->options) <= 4 ? 'progress_bar' : 'horizontal_bar',
                    'data' => $optionCounts,
                    'total_responses' => $totalAnswers
                ];
                
            } elseif ($question->type === 'rating') {
                $ratingCounts = [];
                $ratings = $question->answers->pluck('answer_text')->filter()->map(function($rating) {
                    return (int) $rating;
                });
                
                // Hitung untuk setiap rating 1-5
                for ($i = 1; $i <= 5; $i++) {
                    $count = $ratings->filter(function($rating) use ($i) {
                        return $rating === $i;
                    })->count();
                    
                    $percentage = $ratings->count() > 0 ? round(($count / $ratings->count()) * 100, 1) : 0;
                    
                    $ratingCounts[] = [
                        'label' => "⭐ $i",
                        'value' => $count,
                        'percentage' => $percentage,
                        'rating' => $i
                    ];
                }
                
                // Reverse order untuk menampilkan rating tinggi di atas
                $ratingCounts = array_reverse($ratingCounts);
                
                $averageRating = $ratings->count() > 0 ? round($ratings->avg(), 1) : 0;
                
                $analytics[] = [
                    'question' => $question->question,
                    'type' => $question->type,
                    'chart_type' => 'rating_table',
                    'data' => $ratingCounts,
                    'total_responses' => $ratings->count(),
                    'average_rating' => $averageRating
                ];
            }
        }
        
        // Hitung statistik tambahan
        $totalParticipants = $workshop->participants->count();
        $totalFeedbacks = $workshop->feedbackQuestions()->count();
        $completionRate = $totalParticipants > 0 && $analytics ? 
            round((collect($analytics)->avg('total_responses') / $totalParticipants) * 100, 1) : 0;
        
        // Hitung overall satisfaction jika ada pertanyaan rating
        $overallSatisfaction = 0;
        $ratingQuestions = collect($analytics)->where('type', 'rating');
        if ($ratingQuestions->count() > 0) {
            $overallSatisfaction = round($ratingQuestions->avg('average_rating'), 1);
        }
        
        $data = [
            'workshop' => $workshop,
            'participants' => $workshop->participants,
            'analytics' => $analytics,
            'stats' => [
                'total_participants' => $totalParticipants,
                'quota' => $workshop->quota,
                'completion_rate' => $completionRate,
                'overall_satisfaction' => $overallSatisfaction,
                'total_questions' => $totalFeedbacks
            ],
            'generatedAt' => now()->format('d/m/Y H:i:s')
        ];
        
        $pdf = PDF::loadView('pdf.workshop-report', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 150,
            'defaultMediaType' => 'print',
            'isFontSubsettingEnabled' => true
        ]);
        
        $filename = 'Workshop_Report_' . Str::slug($workshop->title) . '_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
        
    } catch (\Exception $e) {
        Log::error('PDF Download Error: ' . $e->getMessage(), [
            'workshop_id' => $id,
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'PDF tidak dapat diunduh. Silakan coba lagi.',
            'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
        ], 500);
    }
}


}
