@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Redaguoti info</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/updateVideoInfo2/' . $video['id'], 'class' => 'form-horizontal']) !!}

                        <div class="form-group">
                            <label for="difficulty" class="col-lg-2 control-label">Sudėtingumas</label>
                            <div class="col-lg-10">
                                {{ Form::select('difficulty',
                                [1 => 'Labai lengvas', 2 => 'Lengvas', 3 => 'Vidutinis', 4 => 'Sudėtingas', 5 => 'Labai sudėtingas'],
                                $video['difficulty'],
                                 array(
                                'class' => 'form-control',
                                'id' => 'difficulty'
                                ))
                                }}
                            </div>
                        </div>

                        {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Pavadinimas</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="title" value="{{ $video['title'] }}" required>
                            </div>
                        </div>

                        {{ ($errors->has('tags')) ? $errors->first('tags') : '' }}
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Raktažodžiai</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="tags" value="{{ $tags_string }}" required>
                            </div>
                        </div>

                        {{ ($errors->has('description')) ? $errors->first('description') : '' }}
                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Aprašymas</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" name="description" required>{{ $video['description'] }}</textarea>
                                <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Atnaujinti informaciją</button>
                            </div>
                        </div>

                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

