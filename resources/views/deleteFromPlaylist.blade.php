@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Grojaraščiai</b></div>
                    <div class="panel-body">

                        <label for="playlist" class="col-lg-2 control-label">Jūsų grojaraščiai</label>
                        <div class="col-lg-10">

                        <div class="list-group">
                                @foreach($playlists as $key=>$playlist)
                                    @if ($videos[$key] > 0)
                                    <a href="{{ url('deleteFromPlaylist2/' . $playlist->id) }}" class="list-group-item">
                                        <i class="fa fa-comment fa-fw"></i> {{ $playlist->title }}
                                        <br>
                                        {!! $playlist->description !!}
                                        <span class="pull-right text-muted small"><em>{{ $videos[$key] }} video</em></span>
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
@endsection
