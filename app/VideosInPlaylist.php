<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideosInPlaylist extends Model
{
    public function permissions()
    {
        return $this->hasMany('App\Permission', 'video_id', 'video_id');
    }
}
