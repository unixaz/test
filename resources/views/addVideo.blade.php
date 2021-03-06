@extends('layouts.app')

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Pridėti viešą vaizdo įrašą</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/addVideo', 'class' => 'form-horizontal']) !!}

                        <div class="form-group">
                            <label for="difficulty" class="col-lg-2 control-label">Dėstytojai:</label>
                            <div class="col-lg-10">
                            <select class="productName form-control" name="productName[]" id="productName" multiple="multiple"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="difficulty" class="col-lg-2 control-label">Sudėtingumas:</label>
                            <div class="col-lg-10">
                                <select name="difficulty" class="form-control">
                                    <option value="1">Labai lengvas</option>
                                    <option value="2">Lengvas</option>
                                    <option value="3">Vidutinis</option>
                                    <option value="4">Sudėtingas</option>
                                    <option value="5">Labai sudėtingas</option>
                                </select>
                            </div>
                        </div>

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
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                <button type="submit" class="btn btn-primary">Pridėti vaizdo įrašą</button>
                            </div>
                        </div>

                        <script>
                            $( ".productName" ).select2({
                                ajax: {
                                    url: "ajax/professorsList",
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: params.term // search term
                                        };
                                    },
                                    processResults: function (data) {
                                        // parse the results into the format expected by Select2.
                                        // since we are using custom formatting functions we do not need to
                                        // alter the remote JSON data
                                        return {
                                            results: data
                                        };
                                    },
                                    cache: true
                                },
                                minimumInputLength: 2
                            });
                            </script>

                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

