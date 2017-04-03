@extends('layouts.app')

@section('content')

    <div id="wrapper">

    @include('leftNavbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grojaraščio trynimas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-10">

                    {!! Form::open(['url' => '/deletePlaylist', 'class' => 'form-horizontal']) !!}

                    <div class="form-group{{ $errors->has('playlist') ? ' has-error' : '' }}">
                        <label for="playlist" class="col-md-4 control-label">Pareigos</label>
                        <div class="col-md-6">
                            <select name="playlist" class="form-control">
                                <option value="0">Numatytasis</option>
                                @foreach ($playlists as $playlist)
                                    <option value="{{ $playlist->id }}">{{ $playlist->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('playlist'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('playlist') }}</strong>
                                    </span>
                            @endif
                        </div>
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

