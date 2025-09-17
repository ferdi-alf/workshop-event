<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackOption extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
    ];

    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class, 'option_id');
    }
}

