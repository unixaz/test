@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Video pridėjimas</b></div>
                    <div class="panel-body">

                    {!! Form::open(['url' => '/addVideo', 'class' => 'form-horizontal']) !!}

                        {{ ($errors->has('link')) ? $errors->first('link') : '' }}
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">YouTube Nuoroda</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="link" required>
                            </div>
                        </div>

                        {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Pavadinimas</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="title" required>
                            </div>
                        </div>

                        {{ ($errors->has('tags')) ? $errors->first('tags') : '' }}
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Raktažodžiai</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="tags" required>
                            </div>
                        </div>

                        {{ ($errors->has('description')) ? $errors->first('description') : '' }}
                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Aprašymas</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" name="description" required></textarea>
                                <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                <button type="submit" class="btn btn-primary">Pridėti video</button>
                            </div>
                        </div>

                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

