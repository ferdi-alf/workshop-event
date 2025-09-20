<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Banner;
use App\Models\Participant;
use App\Models\Workshop;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function welcome()
    {
        $workshop = Workshop::where('status', 'registered')->first();
        
        if (!$workshop) {
            $workshop = Workshop::where('status', 'finished')
                            ->orderBy('date', 'desc')
                            ->first();
        }
        
        $participantCount = 0;
        $isQuotaFull = false;
        
        if ($workshop) {
            $participantCount = $workshop->participants()->count();
            $isQuotaFull = $participantCount >= $workshop->quota;
        }

        $banners = Banner::where('workshop_id', $workshop ? $workshop->id : null)
                        ->orderBy('position', 'asc')
                        ->get();

                        return view('welcome', compact('workshop', 'participantCount', 'isQuotaFull', 'banners'));
        
    }

    public function register($slug)
    {
        $workshop = Workshop::all()->first(function($w) use ($slug) {
            return Str::slug($w->title) === $slug;
        });
        
        if (!$workshop) {
            abort(404);
        }
        
        $participantCount = $workshop->participants()->count();
        $isQuotaFull = $participantCount >= $workshop->quota;
        
        if ($workshop->status === 'finished') {
            return redirect()->route('welcome')->with(AlertHelper::info('Workshop ini sudah selesai. Anda dapat memberikan feedback.', 'Info'));
        }
        
        if ($isQuotaFull && $workshop->status === 'registered') {
            return redirect()->route('welcome')->with(AlertHelper::error('Maaf, kuota workshop sudah penuh.', 'Error'));
        }
        
        return view('register', compact('workshop', 'participantCount', 'isQuotaFull'));
    }

    public function store(Request $request, $slug)
{
    Log::info('Received workshop registration request', ['slug' => $slug, 'input' => $request->all()]);
    $workshop = Workshop::all()->first(function($w) use ($slug) {
        return Str::slug($w->title) === $slug;
    });
    
    
    if (!$workshop) {
        return redirect()->route('welcome')->with(AlertHelper::error('Workshop tidak ditemukan.', 'Error'));
        log::error('Workshop not found for slug: ' . $slug);
    }else {
        Log::info('Found workshop for registration', ['workshop_id' => $workshop->id, 'title' => $workshop->title]);
    }
    
    $participantCount = $workshop->participants()->count();
    if ($participantCount >= $workshop->quota) {
        return redirect()->back()->with(AlertHelper::error('Maaf, kuota workshop sudah penuh.', 'Error'));
        Log::warning('Registration attempt when quota is full', ['workshop_id' => $workshop->id, 'title' => $workshop->title]);
    }else {
        Log::info('Current participant count', ['workshop_id' => $workshop->id, 'participant_count' => $participantCount, 'quota' => $workshop->quota]);
    }
    
    if ($workshop->status !== 'registered') {
        return redirect()->back()->with(AlertHelper::error('Pendaftaran untuk workshop ini sudah ditutup.', 'Error'));
        Log::warning('Registration attempt for non-registered workshop', ['workshop_id' => $workshop->id, 'status' => $workshop->status]);
    }else {
        Log::info('Workshop is open for registration', ['workshop_id' => $workshop->id, 'status' => $workshop->status]);
    }
    
    $validated = $request->validate([
        'workshop_id' => ['required', 'exists:workshops,id'],
        'name' => ['required', 'string', 'max:255', 'min:2'],
        'email' => [
            'required', 
            'email', 
            'max:255',
            Rule::unique('participants')->where(function ($query) use ($workshop) {
                return $query->where('workshop_id', $workshop->id);
            })
        ],
        'whatsapp' => ['required', 'string', 'max:20', 'min:10'],
        'campus' => ['required', 'string', 'max:255', 'min:2'],
        'major' => ['required', 'string', 'max:255', 'min:2'],
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'name.min' => 'Nama lengkap minimal 2 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar untuk workshop ini.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.min' => 'Nomor WhatsApp minimal 10 karakter.',
        'campus.required' => 'Asal kampus/instansi wajib diisi.',
        'campus.min' => 'Asal kampus/instansi minimal 2 karakter.',
        'major.required' => 'Jurusan/bidang wajib diisi.',
        'major.min' => 'Jurusan/bidang minimal 2 karakter.',
     
    ]);

    if (!$validated) {
        Log::warning('Validation failed for workshop registration', ['workshop_id' => $workshop->id, 'input' => $request->all()]);
        return redirect()->back()->withErrors($validated)->withInput();
    }else {
        Log::info('Validation passed for workshop registration', ['workshop_id' => $workshop->id, 'email' => $validated['email']]);
    }
    
    try {
        $currentParticipantCount = $workshop->participants()->count();
        if ($currentParticipantCount >= $workshop->quota) {
            return redirect()->back()->with(AlertHelper::error('Maaf, kuota workshop sudah penuh saat pendaftaran Anda diproses.', 'Error'));
        }
        
        $whatsapp = $validated['whatsapp'];
        if (strpos($whatsapp, '0') === 0) {
            $whatsapp = '62' . substr($whatsapp, 1);
        }
        if (strpos($whatsapp, '62') !== 0) {
            $whatsapp = '62' . $whatsapp;
        }
        
        Participant::create([
            'workshop_id' => $validated['workshop_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'whatsapp' => $whatsapp,
            'campus' => $validated['campus'],
            'major' => $validated['major'],
        ]);

        Log::info('Participant successfully registered', ['workshop_id' => $workshop->id, 'email' => $validated['email']]);
        
        return redirect()->route('welcome')->with(AlertHelper::success('Pendaftaran berhasil! Anda telah terdaftar untuk workshop ' . $workshop->title . '.', 'Success'));
        
    } catch (\Exception $e) {
        Log::error('Workshop registration failed: ' . $e->getMessage(), [
            'workshop_id' => $workshop->id,
            'email' => $validated['email'] ?? 'unknown',
            'error' => $e->getMessage()
        ]);
        
        return redirect()->back()->with(AlertHelper::error('Terjadi kesalahan saat memproses pendaftaran Anda. Silakan coba lagi.', 'Error'));
    }
}
}
