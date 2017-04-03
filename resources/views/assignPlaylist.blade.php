@extends('layouts.app')

@section('content')

    <div id="wrapper">

    @include('leftNavbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grojaraščio kūrimas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-10">

                    {!! Form::open(['url' => '/createPlaylist', 'class' => 'form-horizontal']) !!}

                    {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                    <div class="form-group">
                        {!! Form::label('Pavadinimas') !!}
                        {!! Form::text('title', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Pavadinimas')) !!}
                    </div>
                    <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Pavadinimas</th>
                            <th>Grojaraštis</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($videos as $video)
                            <tr>
                                <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                @foreach ($video->playlist as $playlist)
                                    <td> {!! $playlist->title !!} </td>
                                @endforeach
                            <br>
                                {{--$video['playlist_id']--}}
                        @endforeach
                        </tbody>
                    </table>
                    </div>

                    {{ ($errors->has('description')) ? $errors->first('description') : '' }}
                    <div class="form-group">
                        {!! Form::label('Aprašymas') !!}
                        {!! Form::textarea('description', null,
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
            </div>
        </div>
    </div>

@endsection

