@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Video</b></div>
                    <div class="panel-body">
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
                </div>

            </div>
            <!--/span-->

        </div>
        <!--/row-->

    </div>

@endsection
