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

                    {!! Form::open(['url' => '/addVideo', 'class' => 'form-horizontal']) !!}

                    {{ ($errors->has('link')) ? $errors->first('link') : '' }}
                    <div class="form-group">
                        {!! Form::label('Nuoroda') !!}
                        {!! Form::text('link', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Nuoroda')) !!}
                    </div>

                    <div class="panel-body">
                        @foreach ($videos as $video)

                            <div class="checkbox">
                                <label><input type="checkbox" value="">{{ $video['title'] }}</label>
                            </div>

                        @endforeach
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

