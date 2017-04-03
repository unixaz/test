@extends('layouts.app')

@section('content')


                    {{--<div class="vid-container">
                        <iframe id="vid_frame" src="http://www.youtube.com/embed/eg6kNoJmzkY?rel=0&showinfo=0&autohide=1" width="560" height="315" frameborder="0"></iframe>
                    </div>


                    <div class="vid-list-container">
                        <div class="vid-list">
                            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/eg6kNoJmzkY?autoplay=1&rel=0&showinfo=0&autohide=1'">
                                <div class="thumb">
                                    <img src="http://img.youtube.com/vi/eg6kNoJmzkY/1.jpg" alt="" />
                                </div>
                                <div class="desc">
                                    Jessica Hernandez & the Deltas - Dead Brains
                                </div>
                            </div>
                        </div>
                    </div>--}}

                    <div class="container">
                        <h2>Image Gallery</h2>
                        <p>The .thumbnail class can be used to display an image gallery.</p>
                        <p>The .caption class adds proper padding and a dark grey color to text inside thumbnails.</p>
                        <p>Click on the images to enlarge them.</p>
                        <div class="row">

                            <iframe id="ytplayer" type="text/html" width="640" height="360"
                                    src="https://www.youtube.com/embed/{{ $videos['video_id'] }}?autoplay=0"
                                    frameborder="0" allowfullscreen></iframe>



                        </div>

                        <div class="row">
                        {!! Form::open(['url' => '/addComment/' . $videos['id'], 'class' => 'form-horizontal']) !!}

                        {{ ($errors->has('comment')) ? $errors->first('comment') : '' }}
                        <div class="form-group">
                            {!! Form::label('Aprašymas') !!}
                            {!! Form::textarea('comment', null,
                            array('required',
                            'class'=>'form-control',
                            'rows' => 3,
                            'placeholder'=>'Skelbimo aprašymas')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Kurti Skelbimą',
                              array('class'=>'btn btn-primary')) !!}
                        </div>

                        {!! Form::close()  !!}
                        </div>

                        <div class="row">

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






                        {{--<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $video['video_id'] }}" frameborder="0" allowfullscreen></iframe>--}}



@endsection
