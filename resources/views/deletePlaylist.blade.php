@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Naujienos</b></div>
                    <div class="panel-body">

                    {!! Form::open(['url' => '/deletePlaylist', 'class' => 'form-horizontal']) !!}

                        <fieldset>

                            {{ ($errors->has('playlists')) ? $errors->first('playlists') : '' }}
                            <div class="form-group">
                                <label for="playlist" class="col-lg-2 control-label">Pavadinimas</label>
                                <div class="col-lg-10">
                                    <select name="playlist" class="form-control">
                                        @foreach ($playlists as $playlist)
                                            <option value="{{ $playlist->id }}">{{ $playlist->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Kurti naujieną</button>
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

