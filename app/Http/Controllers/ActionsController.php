<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\VideoStream;
use App\Info;
use App\Permission;
use App\Setting;
use App\StarVideo;
use App\Tag;
use App\User;
use App\Video;
use App\Playlist;
use App\VideosInPlaylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use JildertMiedema\LaravelPlupload\Facades\Plupload;



class ActionsController extends Controller
{

    public function index()
    {
        $info = Info::orderBy('id', 'DESC')->simplePaginate(10);
        $settings = Setting::first();
        return view('home', compact('info','settings'));
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
            'privacy' => 'public',
            'difficulty' => $request->get('difficulty')
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
        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/addVideo');

    }

    public function myVideos()
    {
        $videos = Video::where('user_id',Auth::id())
            ->get();

        $useFilter = true;
        return view('videoList', compact('videos', 'useFilter'));
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

        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'difficulty'  => $request->get('difficulty'),
            'video_id'  => $request->get('video_id'),
            'user_id'  => $request->get('user_id'),
            'privacy'  => 'public'
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
        $videos = Video::where('user_id', Auth::id())->get();

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
    $videosInPlaylists = new VideosInPlaylist;
    $videosInPlaylists->user_id = Auth::id();
    $videosInPlaylists->playlist_id = $playlist->id;
    $videosInPlaylists->video_id = $selectedVideo;
    $videosInPlaylists->order_in_playlist = 0;
    $videosInPlaylists->save();
}

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/createPlaylist');

    }

    public function assignToPlaylist()
    {
        $videos = Video::where('user_id', Auth::id())->get();
        $playlists = Playlist::where('user_id', Auth::id())
            ->get();
        return view('assignToPlaylist', compact('videos', 'playlists'));

    }

    public function assignToPlaylist2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        if (Playlist::where('user_id', Auth::id())->where('id', $request->playlist)->first()) {

            foreach ($request['ch'] as $selectedVideo) {
                if (!VideosInPlaylist::where('user_id', Auth::id())->where('playlist_id', $request->playlist)->where('video_id', $selectedVideo)->first()) {
                    $videosInPlaylists = new VideosInPlaylist;
                    $videosInPlaylists->user_id = Auth::id();
                    $videosInPlaylists->playlist_id = $request->playlist;
                    $videosInPlaylists->video_id = $selectedVideo;
                    $videosInPlaylists->order_in_playlist = 0;
                    $videosInPlaylists->save();
                }
            }

            flash('Sėkmingai įvykdyta', 'success');
            return redirect('/assignToPlaylist');
        }
        flash('Klaida', 'danger');
        return redirect('/assignToPlaylist');
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

            $videos = VideosInPlaylist::where('user_id', Auth::id())
                ->where('playlist_id', $request->playlist)
                ->get();
            foreach ($videos as $video) {
                VideosInPlaylist::destroy($video->id);
            }

            Playlist::destroy($request->playlist);

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/deletePlaylist');
    }

    public function videoList()
    {
        $allVideos = Video::all();

        foreach ($allVideos as $allVideo) {

            if ($allVideo['privacy'] == 'public')
            {
                $videos[] = $allVideo;
            }elseif ($allVideo['privacy'] == 'unlisted' && !Auth::guest()){
                if (Permission::where('user_id', Auth::id())->where('video_id', $allVideo->id)->first()) {
                    $videos[] = $allVideo;
                }
            }

        }
        $useFilter = true;
        return view('videoList', compact('videos', 'useFilter'));

    }

    public function playlistList()
    {
        $playlists = Playlist::all();
        $videos = array();
        foreach ($playlists as $playlist) {
            $videos[] = VideosInPlaylist::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('playlistList', compact('playlists','videos'));

    }

    public function watchVideo($id)
    {
        $videos = Video::with('tags')->where('id', $id)->first();
        $star = StarVideo::where('user_id', Auth::id())->where('video_id', $id)->first();
        $count = StarVideo::where(['video_id' => $id])->count();

        $comments = Comment::with('users')->where('video_id', $id)->get();
        if ($videos->privacy == 'public'  || $videos->user_id == Auth::id()) {

            return view('watchVideo', compact('videos', 'comments', 'star', 'count'));
        }elseif ($videos->privacy == 'unlisted'){
            $permission = Permission::where('user_id', Auth::id())
            ->where('video_id', $id)->first();
            if ($permission)
            {
                return view('watchVideo', compact('videos', 'comments', 'star', 'count'));
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
            if ($video->user_id == Auth::id())
            {
                $permission = true;
            }
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

        $videosInPlaylists = VideosInPlaylist::where('playlist_id', $id)->get();

        $videosInPlaylists = $videosInPlaylists->sortBy('id')
            ->sortBy('order_in_playlist');

        $orderGreaterThan0 = $videosInPlaylists->filter(function ($value, $key) {
            return $value->order_in_playlist > 0;
        });

        $orderIs0 = $videosInPlaylists->filter(function ($value, $key) {
            return $value->order_in_playlist == 0;
        });

        $videosInPlaylists = $orderGreaterThan0->merge($orderIs0);

        $videos = array();

        foreach ($videosInPlaylists as $videosInPlaylist) {
            $video = Video::find($videosInPlaylist->video_id);

            if ($video['privacy'] == 'public')
            {
                $videos[] = $video;
            }elseif ($video['privacy'] == 'unlisted' && !Auth::guest()){
                if (Permission::where('user_id', Auth::id())->where('video_id', $videosInPlaylist->video_id)->first()) {
                    $videos[] = $video;
                }
            }

        }

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
        $videos = Video::with('users')->where('privacy', 'public')->get();

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
        foreach ($request['ch'] as $selectedVideo) {
            Permission::where('video_id', $selectedVideo)->delete();
        }
        foreach ($request['ch'] as $selectedVideo) {
            StarVideo::where('video_id', $selectedVideo)->delete();
        }
        foreach ($request['ch'] as $selectedVideo) {
            VideosInPlaylist::where('video_id', $selectedVideo)->delete();
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
            $videos[] = VideosInPlaylist::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('changeVideoOrder', compact('playlists','videos'));

    }

    public function changeVideoOrder2(Request $request, $id)
    {

        $videosInPlaylists = VideosInPlaylist::where('user_id', Auth::id())->where('playlist_id', $id)->get();

        $videosInPlaylists = $videosInPlaylists->sortBy('id')
            ->sortBy('order_in_playlist');

        $orderGreaterThan0 = $videosInPlaylists->filter(function ($value, $key) {
            return $value->order_in_playlist > 0;
        });

        $orderIs0 = $videosInPlaylists->filter(function ($value, $key) {
            return $value->order_in_playlist == 0;
        });

        $videosInPlaylists = $orderGreaterThan0->merge($orderIs0);

        $videos = array();
        foreach ($videosInPlaylists as $videosInPlaylist) {
            $videos[] = Video::find($videosInPlaylist->video_id);
        }

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
                VideosInPlaylist::where('user_id', Auth::id())->where('playlist_id', $request->playlist_id)->where('video_id', $videoIdList)
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
        $allVideos = Video::where('user_id', $id)->get();
        $videosCount = array();
        foreach ($playlists as $playlist) {
            $videosCount[] = VideosInPlaylist::where('playlist_id', $playlist->id)
                ->count();
        }

        $videos = array();
        foreach ($allVideos as $allVideo) {

            if ($allVideo['privacy'] == 'public')
            {
                $videos[] = $allVideo;
            }elseif ($allVideo['privacy'] == 'unlisted' && !Auth::guest()){
                if (Permission::where('user_id', Auth::id())->where('video_id', $allVideo->id)->first()) {
                    $videos[] = $allVideo;
                }
            }

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

    public function deleteFromPlaylist()
    {
        $playlists = Playlist::where('user_id', Auth::id())->get();
        $videos = array();
        foreach ($playlists as $playlist) {
            $videos[] = VideosInPlaylist::where('playlist_id', $playlist->id)
                ->count();
        }

        return view('deleteFromPlaylist', compact('playlists','videos'));
    }

    public function deleteFromPlaylist2($id)
    {
        $playlist = Playlist::where('user_id', Auth::id())->where('id', $id)->first();
        $videosInPlaylists = VideosInPlaylist::where('user_id', Auth::id())->where('playlist_id', $id)->get();
        $videoId = array();
        foreach ($videosInPlaylists as $videosInPlaylist) {
            $videoId[] = $videosInPlaylist->video_id;
        }
        $videos = Video::find($videoId);

        return view('deleteFromPlaylist2', compact('videos', 'playlist','id'));

    }

    public function deleteFromPlaylist3(Request $request, $id)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        if (Playlist::where('user_id', Auth::id())->where('id', $id)->first()) {

            foreach ($request['ch'] as $selectedVideo) {
                $videoInPlaylist = VideosInPlaylist::where('user_id', Auth::id())->where('playlist_id', $id)->where('video_id', $selectedVideo)->first();
                $videoInPlaylist->delete();
            }

            flash('Sėkmingai įvykdyta', 'success');
            return redirect('/deleteFromPlaylist');
        }
        flash('Klaida', 'danger');
        return redirect('/deleteFromPlaylist');
    }

    public function starVideo(Request $request)
    {

        if (StarVideo::where('user_id', Auth::id())->where('video_id', $request->video_id)->first()) {
            return response()->json('', 404);
        }else{
            $count = StarVideo::where(['video_id' => $request->video_id])->count();
            StarVideo::updateOrCreate(['user_id' => Auth::id(), 'video_id' => $request->video_id]);
        }
    }

    public function updateVideoInfo($id)
    {
        $video = Video::with('tags')->where('id', $id)->first();
        $tags_string = '';

        foreach ($video->tags as $tags)
        {
            $tags_string = $tags->name . "," . $tags_string ;
        }
        $tags_string = substr($tags_string, 0, -1);

        return view('updateVideoInfo', compact('video','tags_string'));
    }

    public function updateVideoInfo2(Request $request, $id)
    {

        $this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodyta antraštė']
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

        $video = Video::where('id', $id)->first();

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

        $video->difficulty = $request->difficulty;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->save();

        flash('Sėkmingai įvykdyta', 'success');
        return Redirect::back();
    }

    public function searchByDifficulty(Request $request)
    {
        $this->validate(
            $request,
            ['difficulty' => 'required'],
            ['difficulty.required' => 'Nenurodytas sudėtingumas']
        );

        $allVideos = Video::where('difficulty', $request->difficulty)->get();
        $videos = array();
        foreach ($allVideos as $allVideo) {

            if ($allVideo['privacy'] == 'public')
            {
                $videos[] = $allVideo;
            }elseif ($allVideo['privacy'] == 'unlisted' && !Auth::guest()){
                if (Permission::where('user_id', Auth::id())->where('video_id', $allVideo->id)->first()) {
                    $videos[] = $allVideo;
                }
            }

        }
        $useFilter = false;
        return view('videoList', compact('videos', 'useFilter'));

    }

    public function searchByTag(Request $request)
    {
        $this->validate(
            $request,
            ['tag' => 'required'],
            ['tag.required' => 'Nenurodytas raktažodis']
        );

        $tag = Tag::with('videos')->where('name', $request->tag)->first();
        $useFilter = false;
        if ($tag)
        {
            $allVideos = $tag->videos;
            $videos = array();
            foreach ($allVideos as $allVideo) {

                if ($allVideo['privacy'] == 'public')
                {
                    $videos[] = $allVideo;
                }elseif ($allVideo['privacy'] == 'unlisted' && !Auth::guest()){
                    if (Permission::where('user_id', Auth::id())->where('video_id', $allVideo->id)->first()) {
                        $videos[] = $allVideo;
                    }
                }

            }
            return view('videoList', compact('videos', 'useFilter'));
        }else{
            flash('Nerasta video pagal raktažodį', 'danger');
            return Redirect::back();
        }

    }

    public function sortByLikes()
    {
        $starVideos = StarVideo::select('video_id')->groupBy('video_id')->get();

        $videosWithStars = array();
        foreach ($starVideos as $starVideo)
        {
            $videosWithStars[$starVideo->video_id] = StarVideo::where(['video_id' => $starVideo->video_id])->count();
        }
        arsort($videosWithStars);

        $videosWithStars2 = array();
        $starCount = array();
        foreach ($videosWithStars as $key => $videosWithStar) {

            $videosWithStars2[] = Video::where(['id' => $key])->first();
            $starCount[] = $videosWithStar;
        }

            $allVideos = $videosWithStars2;
            $videos = array();
            foreach ($allVideos as $allVideo) {

                if ($allVideo['privacy'] == 'public')
                {
                    $videos[] = $allVideo;
                }elseif ($allVideo['privacy'] == 'unlisted' && !Auth::guest()){
                    if (Permission::where('user_id', Auth::id())->where('video_id', $allVideo->id)->first()) {
                        $videos[] = $allVideo;
                    }
                }

            }
            return view('videoList', compact('videos', 'useFilter', 'starCount'));

    }

    public function toggleStreaming()
    {
        $settings = Setting::first();

        if ($settings->streaming == false)
        {
            $settings->streaming = true;
            $settings->save();
        }elseif ($settings->streaming == true){
            $settings->streaming = false;
            $settings->save();
        }

        return redirect('/');

    }

    public function uploadPrivate()
    {

        $users = User::where('confirmed', true)
            ->whereIn('role', [1,2])
            ->get();

        return view('uploadPrivate', compact('users'));
    }

    public function uploadPrivate2()
    {
        Plupload::receive('file', function ($file)
        {
            $current_time = time();
            $last_private_vid = $current_time . '.' . $file->getClientOriginalExtension();
            Setting::first()->update(['last_private_vid' => $current_time . '.webm']);

            $file->move(storage_path() . '/app/uploads/', $last_private_vid);


            $ffmpeg = \FFMpeg\FFMpeg::create([
                'default_disk' => 'local',

                'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe', //'/usr/bin/ffmpeg',
                'ffmpeg.threads'  => 1,

                'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',//'/usr/bin/ffprobe',

                'timeout' => 300, //3600
            ]);

            $video = $ffmpeg->open(storage_path() . '/app/uploads/' . $last_private_vid);
            $video->save(new \FFMpeg\Format\Video\WebM(), storage_path() . '/app/uploads/' . $current_time . '.webm');

            Storage::delete('/uploads/' . $last_private_vid);


        });


    }

    public function uploadPrivate3(Request $request)
    {

        /*$this->validate(
            $request,
            ['title' => 'required'],
            ['title.required' => 'Nenurodytas pavadinimas']
        );

        $this->validate(
            $request,
            ['tags' => 'required'],
            ['tags.required' => 'Nenurodyti raktažodžiai']
        );

        $this->validate(
            $request,
            ['description' => 'required'],
            ['description.required' => 'Nenurodytas aprašymas']
        );
        $this->validate(
            $request,
            ['file' => 'required'],
            ['file.required' => 'Nepasirinktas failas']
        );

        */

        $settings = Setting::first();

        $video = Video::create([
            'title' => $request->get('title'),
            'description'  => $request->get('description'),
            'difficulty'  => $request->get('difficulty'),
            'video_id'  => $settings->last_private_vid,
            'user_id'  => $request->get('role'),
            'privacy'  => 'unlisted'
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

        return back();

    }

    public function watchPrivate($filename)
    {
        $video = Video::where('video_id', $filename)->first();

        if (Auth::guest())
        {
            $permission = false;
        }elseif (Auth::user())
        {
            if ($video->user_id == Auth::id()){
                $permission = true;
            }else{
                $permissions = Permission::where('user_id', Auth::id())
                    ->where('video_id', $video->id)->first();
                if ($permissions){
                    $permission = true;
                }else{
                    $permission = false;
                }
            }
        }

        if (file_exists($filePath = storage_path() ."/app/uploads/".$filename) && $permission) {
            $stream = new VideoStream($filePath);
            return response()->stream(function() use ($stream) {
                $stream->start();
            });
        }
        return redirect('/');
    }

    public function deletePrivateVideo()
    {
        $videos = Video::with('users')->where('privacy', 'unlisted')->get();
        return view('deletePrivateVideo', compact('videos'));

    }

    public function deletePrivateVideo2(Request $request)
    {
        $this->validate(
            $request,
            ['ch' => 'required'],
            ['ch.required' => 'Nepasirinkti video']
        );

        foreach ($request['ch'] as $selectedVideo) {
            $video = Video::where('id', $selectedVideo)->first();
            Storage::delete('/uploads/' . $video->video_id);
            Permission::where('video_id', $selectedVideo)->delete();
            Comment::where('video_id', $selectedVideo)->delete();
            StarVideo::where('video_id', $selectedVideo)->delete();
            VideosInPlaylist::where('video_id', $selectedVideo)->delete();
        }
        Video::destroy($request['ch']);

        flash('Sėkmingai įvykdyta', 'success');
        return redirect('/deletePrivateVideo');
    }






}
