<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Info;
use App\Tag;
use App\User;
use App\Video;
use App\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

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
            'user_id'  => Auth::id(),
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
        return redirect('/');


        /*$videoid = 'Rcgnqa9LGe0';
        $apikey = 'AIzaSyAJfEeIKCLOu7fwML4ido5uxpAv_aXtpFA';

        $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
        $ytdata = json_decode($json);

        return $ytdata->items[0]->snippet->title . " " . $ytdata->items[0]->snippet->description;*/
    }

    public function myVideos()
    {
        $videos = Video::where('user_id',Auth::id())
            ->get();
        return view('videoList', compact('videos'));
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
            'playlist_id'  => 0,
            'order_in_playlist' => 0
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

    public function createPlaylist()
    {
        $videos = Video::with('playlist')->where('user_id', Auth::id())->get();

        return view('createPlaylist', compact('videos'));
    }

    public function storePlaylist(Request $request)
    {
        $playlist = new Playlist;

        $playlist->user_id = Auth::id();
        $playlist->title = $request['title'];
        $playlist->description = $request['description'];
        $playlist->save();

foreach ($request['ch'] as $selectedVideo) {
    Video::where('user_id', Auth::id())
        ->where('id', $selectedVideo)
        ->update(['playlist_id' => $playlist->id]);
}

        return redirect('/');

    }

    public function assignPlaylist()
    {
        $videos = Video::with('playlist')->where('user_id', Auth::id())->get();
        $playlists = Playlist::where('user_id', Auth::id())
            ->get();
        return view('assignPlaylist', compact('videos', 'playlists'));

    }

    public function storeAssignPlaylist(Request $request)
    {
        foreach ($request['ch'] as $selectedVideo) {
            Video::where('user_id', Auth::id())
                ->where('id', $selectedVideo)
                ->update(['playlist_id' => $request->playlist]);
        }

        return redirect('/assignPlaylist');

    }

    public function deletePlaylist()
    {

        $playlists = Playlist::where('user_id', Auth::id())
            ->get();
        return view('deletePlaylist', compact('playlists'));

    }

    public function storeDeletePlaylist(Request $request)
    {
        if ($request->playlist != 0) {
            $videos = Video::where('user_id', Auth::id())
                ->where('playlist_id', $request->playlist)
                ->get();
            foreach ($videos as $video) {
                $video->update(['playlist_id' => 0]);
            }

            Playlist::destroy($request->playlist);
        }
        return redirect('/deletePlaylist');

    }

    public function videoList()
    {
        $videos = Video::all();

        return view('videoList', compact('videos'));

    }

    public function playlistList()
    {
        $playlists = Playlist::all();
        $videos = array();
        foreach ($playlists as $playlist) {
            $videos[] = Video::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('playlistList', compact('playlists','videos'));

    }

    public function watchVideo($id)
    {
        $comments = Comment::with('users')->where('video_id', $id)->get();
        $videos = Video::findOrFail($id);

        return view('watchVideo', compact('videos','comments'));

    }

    public function addComment($id, Request $request)
    {
        $comments = new Comment;

        $comments->user_id = Auth::id();
        $comments->comment = $request['comment'];
        $comments->video_id = $id;
        $comments->save();

        return Redirect::back();

    }

    public function videoPlaylist($id)
    {

        $videos = Video::where('playlist_id', $id)
            ->get();
        $videos = $videos->sortBy('id')
            ->sortBy('order_in_playlist');

        $videosIdDaugiauUz0 = $videos->filter(function ($value, $key) {
            return $value->order_in_playlist > 0;
        });

        $videosId0 = $videos->filter(function ($value, $key) {
            return $value->order_in_playlist == 0;
        });

        $videos = $videosIdDaugiauUz0->merge($videosId0);



        return view('videoList', compact('videos'));

    }

    public function sortPlaylist()
    {

$playlist_id = 6;
        $videos = Video::where('playlist_id', $playlist_id)
            ->get();

        $videos = $videos->sortBy('id')
        ->sortBy('order_in_playlist');

        return view('sortPlaylist', compact('videos', 'playlist_id'));

    }
    public function sortPlaylist2(Request $request)
    {

foreach ($request->rearranged_list as $key=>$videoIdList)
{
    Video::where('id', $videoIdList)
        ->update(['order_in_playlist' => $key+1]);
}


    }

}
