@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Pridėti vaizdo įrašą į grojaraštį</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/assignToPlaylist', 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            {{ ($errors->has('playlists')) ? $errors->first('playlists') : '' }}
                            <div class="form-group">
                                <label for="playlist" class="col-lg-2 control-label">Grojaraščio pavadinimas</label>
                                <div class="col-lg-10">
                                    <select name="playlist" class="form-control">
                                        @foreach ($playlists as $playlist)
                                            <option value="{{ $playlist->id }}">{{ $playlist->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Jūsų vaizdo įrašai</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($videos as $video)
                                            <tr>
                                                <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary">Priskirti grojaraščiui</button>
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

