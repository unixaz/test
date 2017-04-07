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
        'title', 'description', 'video_id', 'user_id', 'playlist_id', 'order_in_playlist',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function playlist()
    {
        return $this->hasMany('App\Playlist', 'id', 'playlist_id');
    }

}
