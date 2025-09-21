<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'workshop_id',
        'name',
        'email',
        'whatsapp',
        'campus',
        'major',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function clickToWhatsapp()
    {
        if (!$this->whatsapp) {
            return '-';
        }

        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);

        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        return '<a href="https://wa.me/'.$number.'" target="_blank" class="text-green-600 font-semibold hover:underline">'.$this->whatsapp.'</a>';
    }
}
