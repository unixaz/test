@extends('layouts.app')

@section('content')

    <div id="wrapper">

    @include('leftNavbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Video pridejimas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-10">

                    {!! Form::open(['url' => '/addVideo', 'class' => 'form-horizontal']) !!}

                    {{ ($errors->has('link')) ? $errors->first('link') : '' }}
                    <div class="form-group">
                        {!! Form::label('Nuoroda') !!}
                        {!! Form::text('link', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Nuoroda')) !!}
                    </div>

                    {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                    <div class="form-group">
                        {!! Form::label('Pavadinimas') !!}
                        {!! Form::text('title', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Skelbimo pavadinimas')) !!}
                    </div>

                    {{ ($errors->has('tags')) ? $errors->first('tags') : '' }}
                    <div class="form-group">
                        {!! Form::label('Raktažodžiai') !!}
                        {!! Form::text('tags', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Raktažodžiai')) !!}
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

