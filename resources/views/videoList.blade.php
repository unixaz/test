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

                            @foreach ($videos as $video)
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
                            @endforeach


                        </div>
                    </div>






                        {{--<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $video['video_id'] }}" frameborder="0" allowfullscreen></iframe>--}}



@endsection
