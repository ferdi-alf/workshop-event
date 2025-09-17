<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'name',
        'email',
        'whatsapp',
        'answer_text',
        'option_id',
    ];

    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(FeedbackOption::class, 'option_id');
    }
}
