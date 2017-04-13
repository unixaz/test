<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Info;
use App\Permission;
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

    public function index()
    {
        $info = Info::all();
        return view('home', compact('info'));
    }

    public function writeNews()
    {
        return view('writeNews');
    }

    public function writeNews2(Request $request)
    {
        $this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodyta antraštė']
        );
        $this->validate(
            $request,
            ['content' => 'required'],
            ['content.required' => 'Nenurodyta naujiena']
        );

        $info = new Info;

        $info->user_id = Auth::id();
        $info->title = $request['title'];
        $info->description = $request['content'];
        $info->save();

        return redirect('/');
    }

    public function confirmUser()
    {
        $users = User::where('confirmed', false)->get();

        return view('confirmUser', compact('users'));
    }

    public function confirmUser2($action, $id)
    {
        $user = User::findOrFail($id);

        if ($action == 'add')
        {
            $user->confirmed = true;
            $user->save();
        }elseif ($action == 'del')
        {
            $user->delete();
        }

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/confirmUser');
    }

    public function addVideo()
    {
        $users = User::where('confirmed', true)
            ->whereIn('role', [1,2])
            ->get();

        return view('addVideo',compact('users'));
    }


    public function addVideo2(Request $request)
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
            flash('Prasta nuoroda', 'danger');
            return redirect('/addVideo');
        }

        $this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodytas pavadinimas']
        );
        $this->validate(
            $request,
            ['description' => 'required'],
            ['description.required' => 'Nenurodytas aprašymas']
        );
        $this->validate(
            $request,
            ['tags' => 'required'],
            ['tags.required' => 'Nenurodyti raktažodžiai']
        );

        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'video_id'  => $values,
            'user_id'  => $request->get('professor'),
            'playlist_id'  => 0,
            'order_in_playlist' => 0,
            'privacy' => 'public'
        ]);

        if($video)
        {
            $tagNames = explode(',', $request->get('tags'));
            $tagIds = [];
            foreach($tagNames as $tagName)
            {
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag)
                {
                    $tagIds[] = $tag->id;
                }

            }
            $video->tags()->sync($tagIds);
        }
        return redirect('/');

    }

    public function myVideos()
    {
        $videos = Video::where('user_id',Auth::id())
            ->get();
        return view('videoList', compact('videos'));
    }

    public function upload()
    {
        $users = User::where('confirmed', true)
            ->whereIn('role', [1,2])
            ->get();

        return view('upload', compact('users'));
    }

    public function upload_data(Request $request)
    {

        $data = $request->all();

        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'video_id'  => $request->get('video_id'),
            'user_id'  => $request->get('user_id'),
            'playlist_id'  => 0,
            'order_in_playlist' => 0,
            'privacy'  => $request->get('privacy')
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

    public function createPlaylist2(Request $request)
    {

        $this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodytas pavadinimas']
        );
        $this->validate(
            $request,
            ['description' => 'required'],
            ['description.required' => 'Nenurodytas aprašymas']
        );
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

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

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/createPlaylist');

    }

    public function assignPlaylist()
    {
        $videos = Video::with('playlist')->where('user_id', Auth::id())->get();
        $playlists = Playlist::where('user_id', Auth::id())
            ->get();
        return view('assignPlaylist', compact('videos', 'playlists'));

    }

    public function assignPlaylist2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        foreach ($request['ch'] as $selectedVideo) {
            Video::where('user_id', Auth::id())
                ->where('id', $selectedVideo)
                ->update(['playlist_id' => $request->playlist]);
        }

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/assignPlaylist');

    }

    public function deletePlaylist()
    {

        $playlists = Playlist::where('user_id', Auth::id())
            ->get();
        return view('deletePlaylist', compact('playlists'));

    }

    public function deletePlaylist2(Request $request)
    {
        $this->validate(
            $request,
            ['playlist' => 'required'],
            ['playlist.required' => 'Nepasirinktas grojaraštis']
        );

        if ($request->playlist != 0) {
            $videos = Video::where('user_id', Auth::id())
                ->where('playlist_id', $request->playlist)
                ->get();
            foreach ($videos as $video) {
                $video->update(['playlist_id' => 0]);
            }

            Playlist::destroy($request->playlist);
        }
        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/deletePlaylist');

    }

    public function videoList()
    {
        $videos = Video::with('permissions')->get();

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
        $videos = Video::findOrFail($id);
        $comments = Comment::with('users')->where('video_id', $id)->get();
        if ($videos->privacy == 'public'  || $videos->user_id == Auth::id()) {

            return view('watchVideo', compact('videos', 'comments'));
        }elseif ($videos->privacy == 'unlisted'){
            $permission = Permission::where('user_id', Auth::id())
            ->where('video_id', $id)->first();
            if ($permission)
            {
                return view('watchVideo', compact('videos', 'comments'));
            }else{
                return redirect('/');
            }
        }

    }

    public function addComment($id, Request $request)
    {
        $this->validate(
            $request,
            ['comment' => 'required'],
            ['comment.required' => 'Neparašytas komentaras']
        );

        $video = Video::findOrFail($id);

        if ($video->privacy == 'public') {
            $comments = new Comment;

            $comments->user_id = Auth::id();
            $comments->comment = $request['comment'];
            $comments->video_id = $id;
            $comments->save();
        }elseif ($video->privacy == 'unlisted'){
            $permission = Permission::where('user_id', Auth::id())
                ->where('video_id', $id)->first();
            if ($permission)
            {
                $comments = new Comment;

                $comments->user_id = Auth::id();
                $comments->comment = $request['comment'];
                $comments->video_id = $id;
                $comments->save();
            }
        }

        return Redirect::back();

    }

    public function videoPlaylist($id)
    {
        $videos = Video::with('permissions')
            ->where('playlist_id', $id)->get();

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

    public function changeOwner()
    {
        $videos = Video::with('users')->get();

        $professors = User::where('confirmed', true)
            ->whereIn('role', [1,2])
            ->get();
        return view('changeOwner', compact('videos', 'professors'));
    }

    public function changeOwner2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        foreach ($request['ch'] as $selectedVideo) {
            Video::where('id', $selectedVideo)
                ->update(['user_id' => $request->professor]);
        }

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/changeOwner');

    }

    public function deleteVideo()
    {
        $videos = Video::with('users')->get();

        return view('deleteVideo', compact('videos'));

    }

    public function deleteVideo2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        Video::destroy($request['ch']);

        foreach ($request['ch'] as $selectedVideo) {
            Comment::where('video_id', $selectedVideo)->delete();
        }

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/deleteVideo');
    }

    public function changePrivacy()
    {
        $videos = Video::where('user_id', Auth::id())
            ->get();
        return view('changePrivacy', compact('videos'));

    }

    public function changePrivacy2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        foreach ($request['ch'] as $selectedVideo) {
            Video::where('user_id', Auth::id())
                ->where('id', $selectedVideo)
                ->update(['privacy' => $request->privacy]);
        }

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/changePrivacy');

    }

    public function videoPermissions()
    {
        $videos = Video::where('user_id', Auth::id())
            ->where('privacy', 'unlisted')
            ->get();
        return view('videoPermissions', compact('videos'));

    }

    public function videoPermissions2($id)
    {
        Video::findOrFail($id);

            $users = User::with('permission')
                ->where('confirmed', true)
                ->get();

            return view('videoPermissions2', compact('users', 'id'));

    }

    public function videoPermissions3(Request $request, $id)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        if ($request->privacy == 1)
        {

            foreach ($request['ch'] as $selectedVideo) {

                $permissions = Permission::where('user_id', $selectedVideo)
                    ->where('video_id', $id)
                    ->first();

                if (is_null($permissions)) {
                    $permission = new Permission;

                    $permission->user_id = $selectedVideo;
                    $permission->video_id = $id;
                    $permission->save();
                }
            }
        }
        if ($request->privacy == 0)
        {
            foreach ($request['ch'] as $selectedVideo) {
                Permission::where('user_id', $selectedVideo)
                    ->where('video_id', $id)->delete();
            }

        }

        flash('Sėkmingai įvykdyta', 'success');
        return Redirect::back();
    }

    public function changeVideoOrder()
    {
        $playlists = Playlist::where('user_id', Auth::id())->get();
        $videos = array();
        foreach ($playlists as $playlist) {
            $videos[] = Video::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('changeVideoOrder', compact('playlists','videos'));

    }

    public function changeVideoOrder2(Request $request, $id)
    {
        $videos = Video::where('playlist_id', $id)
            ->where('user_id', Auth::id())
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

        return view('changeVideoOrder2', compact('videos', 'id'));

    }
    public function changeVideoOrder3(Request $request)
    {
        if (empty($request->rearranged_list))
        {
            return response()->json([
                'message' => 'Pozicijos neišsaugotos',
                'resp' => 'false'
            ]);
        }else {
            foreach ($request->rearranged_list as $key => $videoIdList) {
                Video::where('id', $videoIdList)
                    ->update(['order_in_playlist' => $key + 1]);
            }

            return response()->json([
                'message' => 'Pozicijos išsaugotos',
                'resp' => 'true'
            ]);
        }

    }

    public function professorsList()
    {
        $professors = User::where('confirmed', true)
            ->whereIn('role', [1,2])
            ->get();
        return view('professorsList', compact('professors'));

    }

    public function professorsList2($id)
    {
        $professor = User::findOrFail($id);
        $playlists = Playlist::where('user_id', $id)->get();
        $videos = Video::with('permissions')->where('user_id', $id)->get();
        $videosCount = array();
        foreach ($playlists as $playlist) {
            $videosCount[] = Video::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('professorsList2', compact('playlists','videosCount', 'videos', 'professor'));

    }

    public function newsAction($id, Request $request)
    {
        $info = Info::findOrFail($id);
        if ($request->optionsRadios == 'delete')
        {
            $info->delete();

            flash('Sėkmingai įvykdyta', 'success');
            return redirect('/');
        }elseif ($request->optionsRadios == 'update')
        {
            return view('updateNews', compact('info'));
        }

        flash('Nepasirinktas veiksmas', 'danger');
        return redirect('/');

    }

    public function updateNews2(Request $request, $id)
    {
        $this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodyta antraštė']
        );
        $this->validate(
            $request,
            ['content' => 'required'],
            ['content.required' => 'Nenurodyta naujiena']
        );

        $info = Info::where('id', $id)->first();

        $info->title = $request['title'];
        $info->description = $request['content'];
        $info->save();

        return redirect('/');
    }

    public function deleteComment($id, Request $request)
    {
        $comment= Comment::findOrFail($id);
        if ($request->optionsRadios == 'delete')
        {
            $comment->delete();

            flash('Sėkmingai įvykdyta', 'success');
            return Redirect::back();
        }

        flash('Nepasirinktas veiksmas', 'danger');
        return Redirect::back();

    }


}
