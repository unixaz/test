<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regkey extends Model
{
    protected $fillable = [
        'user_id', 'role_id', 'regkey',
    ];
}
