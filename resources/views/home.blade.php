@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                @if ($settings->streaming == true)
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tiesioginė transliacija</b></div>
                    <div class="panel-body">
                        <iframe class="center-block" width="45%" height="315" src="https://www.youtube.com/embed/live_stream?channel={{ env('YOUTUBE_CHANNEL_ID') }}" frameborder="0" allowfullscreen=""></iframe>
                    </div>
                </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Naujienos</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        @foreach($info as $infos)
                            <b> {{ $infos->title }}</b>
                                <br>
                            {!! $infos->description !!}
                            <small><i>{{ $infos->created_at }}</i></small>

                            @unless (Auth::guest())
                                @if (Auth::user()->isAdmin())
                                {!! Form::open(['url' => '/newsAction/' . $infos->id, 'class' => 'form-horizontal']) !!}
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadios" value="delete"> Trinti
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadios" value="update"> Redaguoti
                                    </label>
                                <button type="submit" class="btn btn-link btn-xs">Atlikti veiksmą</button>
                                {!! Form::close()  !!}
                                @endif
                            @endunless
                            <hr>
                        @endforeach

                        {{ $info->links() }}

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
