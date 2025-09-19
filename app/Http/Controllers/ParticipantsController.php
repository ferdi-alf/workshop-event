<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index() {
        $data = Participant::get();
        return view('participants', compact('data'));
    }
}
