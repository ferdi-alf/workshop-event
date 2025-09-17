<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'time_start',
        'time_end',
        'location',
        'benefit',
        'quota',
        'status',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function feedbackQuestions()
    {
        return $this->hasMany(FeedbackQuestion::class);
    }
}
