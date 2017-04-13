@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>{{ $professor->name }}</b></div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#video" data-toggle="tab" aria-expanded="true">Video</a></li>
                            <li class=""><a href="#playlists" data-toggle="tab" aria-expanded="false">Grojaraščiai</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active in" id="video">
                                <br>
                                <div class="row">
                                    @foreach ($videos as $video)
                                        @if ($video['privacy'] == 'public')
                                            <div class="col-lg-2 col-sm-3 col-xs-4">
                                                <div class="thumbnail">
                                                    <a href="{{ url('watch/' . $video['id']) }}">
                                                        <img src="http://img.youtube.com/vi/{{ $video['video_id'] }}/default.jpg" class="img-responsive">
                                                        <div class="caption">
                                                            <p>{{ $video['title'] }}</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @elseif($video['privacy'] == 'unlisted' && !Auth::guest())
                                            @foreach ($video->permissions as $permission)
                                                @if ($permission->video_id == $video['id'] && $permission->user_id == Auth::user()->id)
                                                    <div class="col-lg-2 col-sm-3 col-xs-4">
                                                        <div class="thumbnail">
                                                            <a href="{{ url('watch/' . $video['id']) }}">
                                                                <img src="http://img.youtube.com/vi/{{ $video['video_id'] }}/default.jpg" class="img-responsive">
                                                                <div class="caption">
                                                                    <p>{{ $video['title'] }}</p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane" id="playlists">
                                <br>
                                <div class="list-group">
                                    @foreach($playlists as $key=>$playlist)
                                        @if ($videosCount[$key] > 0)
                                            <a href="{{ url('videoPlaylist/' . $playlist->id) }}" class="list-group-item">
                                                <i class="fa fa-comment fa-fw"></i> {{ $playlist->title }}
                                                <br>
                                                {!! $playlist->description !!}
                                                <span class="pull-right text-muted small"><em>{{ $videosCount[$key] }} video</em></span>
                                                <br>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
