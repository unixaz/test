@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><a href="{{ url()->previous() }}" class="btn btn-primary btn-sm" role="button">Atgal</a></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        @if (isset($useFilter) && $useFilter == true)
                        <div id="showmenu">
                            <button type="button" class="btn btn-primary btn-xs glyphicon glyphicon-triangle-bottom"> Filtruoti</button>
                        </div>
                        @endif

                        <div class="menu" style="display: none;">
                            {!! Form::open(['url' => '/searchByDifficulty', 'class' => 'form-inline']) !!}

                            <div class="form-group">
                                <label for="difficulty">Sudėtingumas:</label>
                                <select name="difficulty" class="form-control">
                                    <option value="1">Labai lengvas</option>
                                    <option value="2">Lengvas</option>
                                    <option value="3">Vidutinis</option>
                                    <option value="4">Sudėtingas</option>
                                    <option value="5">Labai sudėtingas</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filtruoti</button>
                            {!! Form::close()  !!}
<br>
                            {!! Form::open(['url' => '/searchByTag', 'class' => 'form-inline']) !!}

                            <div class="form-group">
                                <label for="tag">Raktažodis:</label>
                                <input type="text" class="form-control" name="tag">
                            </div>
                            <button type="submit" class="btn btn-primary">Filtruoti</button>
                            {!! Form::close()  !!}
                            <br>
                            <a href="{{ url('sortByLikes') }}" class="btn btn-primary" role="button">Rodyti mėgstamiausius</a>

                        </div>

<hr>

                        <div class="row">
                            @if (!empty($videos))
                            @foreach ($videos as $key => $video)

                                    <div class="col-lg-2 col-sm-3 col-xs-4">
                                        <div class="thumbnail">
                                            <a href="{{ url('watch/' . $video['id']) }}">
                                                @if (strpos($video['video_id'], "."))
                                                    <img src="{{ url('/images/lock.jpg') }}" class="img-responsive">
                                                @else
                                                <img src="http://img.youtube.com/vi/{{ $video['video_id'] }}/default.jpg" class="img-responsive">
                                                @endif
                                                <div class="caption">
                                                    {{ $video['title'] }}
                                                    @if (!empty($starCount))
                                                    <br>
                                                    <small>Patinka: {{ $starCount[$key] }}</small>
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#showmenu').click(function() {
                $('.menu').slideToggle("fast");
            });
        });
    </script>

@endsection
