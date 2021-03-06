@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Skelbti naujieną</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        {!! Form::open(['url' => '/writeNews', 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            {{ ($errors->has('title')) ? $errors->first('title') : '' }}
                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Antraštė</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="title" maxlength="100" required>
                                </div>
                            </div>


                            {{ ($errors->has('content')) ? $errors->first('content') : '' }}
                            <div class="form-group">
                                <label for="content" class="col-lg-2 control-label">Naujiena</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="content" id="input" rows="5"></textarea>
                                    <div id="character_count"></div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary" onclick="return ValidateCharacterLength();">Skelbti naujieną</button>
                                </div>
                            </div>
                            </fieldset>
                        {!! Form::close()  !!}

                    </div>
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
            language: 'lt',
            setup: function (ed) {
                ed.on('keyup', function (e) {
                    var count = CountCharacters();
                    document.getElementById("character_count").innerHTML = count + "/500 simbolių";
                });
            }
        };

        tinymce.init(editor_config);

        function CountCharacters() {
            var content = tinymce.activeEditor.getContent().length;
            return content;
        };

        function ValidateCharacterLength() {
            var max = 500;
            var count = CountCharacters();
            if (count > max) {
                alert("Leidžiama iki " + max + " simbolių.")
                return false;
            }

        }

    </script>﻿
@endsection

