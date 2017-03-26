<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionsController extends Controller
{
    public function create()
    {
        return view('newsForm');
    }

    public function store(Request $request)
    {
        $info = new Info;

        $info->user_id = Auth::id();
        $info->title = $request['title'];
        $info->description = $request['content'];
        $info->save();

        return redirect('home');
    }
}
