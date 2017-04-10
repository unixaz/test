@extends('layouts.app')

@section('content')

<style>
    .your-centered-div {
        width: 560px; /* you have to have a size or this method doesn't work */
        height: 315px; /* think about making these max-width instead - might give you some more responsiveness */

        position: absolute; /* positions out of the flow, but according to the nearest parent */
        top: 0; right: 0; /* confuse it i guess */
        bottom: 0; left: 0;
        margin: auto; /* make em equal */
    }
    </style>
    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Video</b></div>
                    <div class="panel-body">
                        <iframe class="center-block" width="45%" height="315" src="https://www.youtube.com/embed/{{ $videos['video_id'] }}" frameborder="0" allowfullscreen=""></iframe>

                        <hr>


                        {!! Form::open(['url' => '/addComment/' . $videos['id'], 'class' => 'form-horizontal']) !!}

                        {{ ($errors->has('comment')) ? $errors->first('comment') : '' }}
                        <div class="form-group">
                            <label for="comment" class="col-lg-1 control-label">Komentaras</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="comment" id="input" rows="3"></textarea>
                                <span class="help-block">Šiame lauke galite rašyti naujieną.</span>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-primary">Kurti naujieną</button>
                            </div>
                        </div>

                        {!! Form::close()  !!}




                        @foreach($comments as $comment)

                                <a href="#" class="list-group-item">

                                    {!! $comment->comment !!}
                                        <br>
                                    <small>{!! $comment->created_at !!}</small>
                                    @foreach ($comment->users as $user)
                                        <span class="pull-right text-muted small"><em>{!! $user->name !!} </em></span>
                                    @endforeach

                                    <br>
                                </a>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
