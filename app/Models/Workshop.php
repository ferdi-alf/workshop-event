<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function getSlugatAttribute()
    {
        return Str::slug($this->title);
    }

    public function findBySlug($slug)
    {
        return static::all()->first(function($workshop) use ($slug) {
            return Str::slug($workshop->title) === $slug;
        });
    }

    public function isQuotaFull()
    {
        return $this->participants()->count() >= $this->quota;
    }

    public function getRemainingQuotaAttribute()
    {
        return $this->quota - $this->participants()->count();
    }

    public function getParticipantCountAttribute()
    {
        return $this->participants()->count();
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }

    public function canRegister()
    {
        return $this->status === 'registered' && !$this->isQuotaFull();
    }
}