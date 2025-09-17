<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'workshop_id',
        'image_url',
        'caption',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
