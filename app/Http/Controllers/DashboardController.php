<?php

namespace App\Http\Controllers;

use App\Models\FeedbackAnswer;
use App\Models\FeedbackQuestion;
use App\Models\Participant;
use App\Models\Workshop;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $workshop = Workshop::with('participants')
            ->select('id', 'title')
            ->where('status', 'registered')
            ->first();

        $ratings =  FeedbackAnswer::whereHas('question', function($q) {
            $q->where('type', 'rating');
        })->pluck('answer_text')->map(fn($r) => (int) $r);

        $rataRata = $ratings->count() > 0 ? round($ratings->avg(), 1) : 0;

        $ratingData = [
            'rating' => $ratings,
            'rataRata' => $rataRata
        ];

        $latestWorkshop = Workshop::latest('date')->first();
        $previousWorkshop = Workshop::where('id', '<', $latestWorkshop->id)
        ->orderBy('id', 'desc')
        ->first();

        $latestCount = $latestWorkshop ? $latestWorkshop->participants()->count() : 0;
        $previousCount = $previousWorkshop ? $previousWorkshop->participants()->count() : 0;

        $status = $latestCount > $previousCount ? 'naik' : ($latestCount < $previousCount ? 'turun' : 'tetap');

         $totalParticipants = [
            'total' => Participant::count(),
            'status' => $status,
        ];

        $totalWorkshops = Workshop::count();
        $totalUsers = \App\Models\User::count();

        $latestWorkshops = Workshop::latest('date')->take(4)->get()->map(function ($w) {
            return [
                'title' => $w->title,
                'total_participant' => $w->participants()->count(),
            ];
        });
        
        return view('dashboard', compact('workshop', 'ratingData', 'totalWorkshops', 'totalParticipants', 'totalUsers', 'latestWorkshops'));
    }
}
