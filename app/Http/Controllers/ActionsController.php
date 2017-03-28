<?php

namespace App\Http\Controllers;

use App\Info;
use App\Tag;
use App\User;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        return redirect('/');
    }

    public function confirm()
    {
        $users = User::where('confirmed',false)->get();
        return view('confirm', compact('users'));
    }
    public function confirm2($action, $id)
    {
        $user = User::find($id);

        if ($action == 'add')
        {
            $user->confirmed = true;
            $user->save();
        }elseif ($action == 'del')
        {
            $user->delete();
        }

        return redirect('confirm');
    }

    public function addVideo()
    {
        return view('addVideo');
    }


    public function storeVideo(Request $request)
    {

        $url = $request->get('link');

        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            $values = $id[1];
        } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
            $values = $id[1];
        } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
            $values = $id[1];
        } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            $values = $id[1];
        }
        else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
            $values = $id[1];
        } else {
        dd('prasta nuoroda');
        }




        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'video_id'  => $values,
            'user_id'  => Auth::id()
        ]);

        if($video)
        {
            $tagNames = explode(',', $request->get('tags'));
            $tagIds = [];
            foreach($tagNames as $tagName)
            {
                //$post->tags()->create(['name'=>$tagName]);
                //Or to take care of avoiding duplication of Tag
                //you could substitute the above line as
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag)
                {
                    $tagIds[] = $tag->id;
                }

            }
            $video->tags()->sync($tagIds);
        }
        return redirect('/');


        /*$videoid = 'Rcgnqa9LGe0';
        $apikey = 'AIzaSyAJfEeIKCLOu7fwML4ido5uxpAv_aXtpFA';

        $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
        $ytdata = json_decode($json);

        return $ytdata->items[0]->snippet->title . " " . $ytdata->items[0]->snippet->description;*/
    }

    public function upload()
    {
        $users = User::where('confirmed',true)
            ->where('role', 1)
            ->get();
        return view('upload', compact('users'));
    }

    public function upload_data(Request $request)
    {

        $data = $request->all();
        Log::info(print_r($data, true));


        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'video_id'  => $request->get('video_id'),
            'user_id'  => $request->get('user_id'),
            'playlist_id'  => 0
        ]);

        if($video)
        {
            $tagNames = explode(',', $request->get('tags'));
            $tagIds = [];
            foreach($tagNames as $tagName)
            {
                //$post->tags()->create(['name'=>$tagName]);
                //Or to take care of avoiding duplication of Tag
                //you could substitute the above line as
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag)
                {
                    $tagIds[] = $tag->id;
                }

            }
            $video->tags()->sync($tagIds);
        }
    }

    public function myVideos()
    {
        $videos = Video::where('user_id', Auth::id())->get();

        return view('myVideos', compact('videos'));

    }

    public function createPlaylist()
    {
        $videos = Video::where('user_id', Auth::id())->get();

        return view('createPlaylist', compact('videos'));
    }
}
