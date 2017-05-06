@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><a href="{{ url()->previous() }}" class="btn btn-primary btn-sm" role="button">Atgal</a></div>
                    <div class="panel-body">
                        @if (strpos($videos['video_id'], "."))
                            <video class="center-block" width="45%" height="315" controls controlsList="nodownload">
                                <source src="{{ route('watchPrivate', $videos['video_id'])  }}" type="video/mp4">
                                Jūsų naršyklė nepalaiko vaizdo įrašų žymės.
                            </video>
                        @else
                            <iframe class="center-block" width="45%" height="315" src="https://www.youtube.com/embed/{{ $videos['video_id'] }}" frameborder="0" allowfullscreen=""></iframe>
                        @endif

                        <b>{{ $videos['title'] }}</b>
                        <br>
                        {{ $videos['description'] }}
                        <br>
                        <small>Sudėtingumas:
                        @if ($videos['difficulty'] == 1)
                            Labai lengvas
                        @elseif ($videos['difficulty'] == 2)
                            Lengvas
                        @elseif ($videos['difficulty'] == 3)
                            Vidutinis
                        @elseif ($videos['difficulty'] == 4)
                            Sunkus
                        @elseif ($videos['difficulty'] == 5)
                            Labai sunkus
                        @endif
<br>
                        Raktažodžiai:
                        @foreach($videos->tags as $tags)
                          {{ $tags->name }}

                        @endforeach

                        @if (isset($star) || Auth::guest())
                            <button type="button" class="btn btn-default btn-sm pull-right" disabled>
                                <span class="glyphicon glyphicon-star"></span> ({{ $count }}) Patinka
                            </button>
                        @else
                            <button type="button" class="btn btn-default btn-sm pull-right" id="star">
                                <span class="glyphicon glyphicon-star-empty"></span> ({{ $count }}) Patinka
                            </button>
                        @endif
                        </small>
                            @if ($videos['privacy'] == 'public')
                        <a href="#" class="btn btn-primary btn-facebook btn-sm pull-right"
                           onclick="
                                   window.open(
                                   'https://www.facebook.com/dialog/feed?app_id={{ env('FACEBOOK_API') }}' +
                                   '&link={{ Request::fullUrl() }}' +
                                   '&picture={{ asset('images/su_logo.jpg') }}' +
                                   '&caption=^Šiaulių%20universitetas' +
                                   '&description={{ $videos['title'] }}',
                                   'facebook-share-dialog',
                                   'width=626,height=436');
                                   return false;">
                            <i class="fa fa-facebook fa-fw"></i>Dalintis
                        </a>
                        @endif

                        @unless (Auth::guest())
                            @if (Auth::user()->isAdmin())
                                <a href="{{ url('updateVideoInfo/' . $videos['id']) }}" class="btn btn-info btn-sm pull-right" role="button">Redaguoti info</a>
                            @endif
                        @endunless

                        <hr>

                        @if(!Auth::guest())
                        {!! Form::open(['url' => '/addComment/' . $videos['id'], 'class' => 'form-horizontal']) !!}

                        <div class="form-group">
                            @include('flash::message')
                            @include('errors')
                            <label for="comment" class="col-lg-1 control-label">Komentaras</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="comment" id="input" rows="3"></textarea>
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

    <script>

        $(document).ready(function(){

            $('#star').click( function(){

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/bakalauras/public/starVideo',
                    type: 'POST',
                    data: {
                        video_id:'<?php echo $videos['id']; ?>',
                    },
                    datatype: 'json',
                    success: function(){
                        $('#star').find('span').removeClass("glyphicon-star-empty").addClass("glyphicon-star");
                        document.getElementById("star").disabled = true;
                    }

                });
            });

        });

    </script>
@endsection
