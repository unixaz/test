@extends('layouts.app')

@section('content')

    <div id="wrapper">

    @include('leftNavbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Naujienos kūrimas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-10">

                {!! Form::open(['url' => '/ideti', 'class' => 'form-horizontal']) !!}

                {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                    <div class="form-group">
                        {!! Form::label('Pavadinimas') !!}
                        {!! Form::text('title', null,
                        array('required',
                        'class'=>'form-control',
                        'placeholder'=>'Skelbimo pavadinimas')) !!}
                    </div>

                {{ ($errors->has('ccontent')) ? $errors->first('ccontent') : '' }}
                    <div class="form-group">
                        {!! Form::label('Aprašymas') !!}
                        <textarea class="form-control" name="content" id="input" rows="5"></textarea>
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

    <script src="{{ URL::to('js/tinymce/tinymce.min.js') }}"></script>

    <script>
        var editor_config = {
            path_absolute : "{{ URL::to('/') }}/",
            selector : "textarea",
            plugins: [
                "advlist autolink lists link  charmap print preview hr",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking save contextmenu directionality",
                "emoticons paste textcolor colorpicker textpattern"
            ],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
            relative_urls: false,
            target_list: false,
            default_link_target: "_blank",
            language: 'lt'
        };

        tinymce.init(editor_config);
    </script>﻿
@endsection

