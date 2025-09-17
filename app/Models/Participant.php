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
}
