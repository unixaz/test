@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Kurti grojarašyį</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/createPlaylist', 'class' => 'form-horizontal']) !!}

                        <fieldset>

                            {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Grojaraščio pavadinimas</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Jūsų video</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                            <th>Priklauso grojaraščiui</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($videos as $video)
                                                <tr>
                                                    <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                                    @foreach ($video->playlist as $playlist)
                                                        <td> {!! $playlist->title !!} </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{ ($errors->has('description')) ? $errors->first('description') : '' }}
                            <div class="form-group">
                                <label for="content" class="col-lg-2 control-label">Aprašymas</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="description" id="input" rows="5" required></textarea>
                                    <span class="help-block">Šiame lauke galite rašyti naujieną.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary">Kurti grojaraštį</button>
                                </div>
                            </div>

                        </fieldset>

                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

