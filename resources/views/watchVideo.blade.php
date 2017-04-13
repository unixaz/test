@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><a href="{{ url()->previous() }}" class="btn btn-primary btn-sm" role="button">Atgal</a></div>
                    <div class="panel-body">
                        <iframe class="center-block" width="45%" height="315" src="https://www.youtube.com/embed/{{ $videos['video_id'] }}" frameborder="0" allowfullscreen=""></iframe>
                        <b>{{ $videos['title'] }}</b>
                        <br>
                        {{ $videos['description'] }}
                        <hr>

                        @if(!Auth::guest())
                        {!! Form::open(['url' => '/addComment/' . $videos['id'], 'class' => 'form-horizontal']) !!}

                        <div class="form-group">
                            @include('flash::message')
                            @include('errors')
                            <label for="comment" class="col-lg-1 control-label">Komentaras</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="comment" id="input" rows="3"></textarea>
                                <span class="help-block">Šiame lauke galite rašyti naujieną.</span>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-primary">Komentuoti</button>
                            </div>
                        </div>

                        {!! Form::close()  !!}
                        @endif



                        @foreach($comments as $comment)

                                <div class="list-group-item">

                                    {!! $comment->comment !!}
                                        <br>
                                    <small>{!! $comment->created_at !!}</small>

                                    {!! Form::open(['url' => '/deleteComment/' . $comment->id, 'class' => 'form-horizontal']) !!}
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadios" value="delete"> Trinti
                                    </label>
                                    <button type="submit" class="btn btn-link btn-xs">Atlikti veiksmą</button>
                                    {!! Form::close()  !!}

                                    @foreach ($comment->users as $user)
                                        <span class="pull-right text-muted small"><em>{!! $user->name !!} </em></span>
                                    @endforeach

                                    <br>
                                </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
