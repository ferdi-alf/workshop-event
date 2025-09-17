<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    protected $fillable = [
        'workshop_id',
        'question',
        'type',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function options()
    {
        return $this->hasMany(FeedbackOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class, 'question_id');
    }
}
