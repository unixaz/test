<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'video_id', 'user_id',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
