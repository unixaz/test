@extends('layouts.app')

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Įkelti privatų vaizdo įrašą</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        {!! Form::open(['url' => '/uploadPrivate2', 'class' => 'form-horizontal', 'enctype' => "multipart/form-data"]) !!}

                        <div class="form-group">
                            <label for="productName">Dėstytojas:</label>
                                <select class="productName form-control" name="productName" id="productName" multiple="multiple"></select>
                        </div>

                        <div class="form-group">
                            <label for="difficulty">Sudėtingumas:</label>
                            <select name="difficulty" id="difficulty" class="form-control">
                                <option value="1">Labai lengvas</option>
                                <option value="2">Lengvas</option>
                                <option value="3">Vidutinis</option>
                                <option value="4">Sudėtingas</option>
                                <option value="5">Labai sudėtingas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Pavadinimas:</label>
                            <input type="text" id="title" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="tags">Raktažodžiai:</label>
                            <input type="text" id="tags" class="form-control" name="tags" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Aprašymas:</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                        </div>

                        <script src="{{ asset('js/plupload.full.min.js') }}"></script>
                        <script src="{{ asset('js/jquery.plupload.queue.js') }}"></script>

                        <script>
                            $(function() {
                                $("#uploader").pluploadQueue({
                                    runtimes : 'html5',
                                    max_file_size : '100mb',
                                    url : '../uploadPrivate2',
                                    chunk_size: '1mb',
                                    multi_selection: false,
                                    dragdrop: false,
                                    filters : [
                                        {title : "mp4 files", extensions : "mp4,avi,flv,3gp,wmv.mov"}
                                    ]
                                });

                                var uploader = $('#uploader').pluploadQueue();

                                uploader.bind('FilesAdded', function(up, files) {
                                    while (up.files.length > 1) {
                                        up.removeFile(up.files[0]);
                                    }
                                });

                                uploader.bind('FileUploaded', function() {
                                    if (uploader.files.length == (uploader.total.uploaded + uploader.total.failed)) {
                                        $.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            url: 'uploadPrivate3',
                                            type: 'POST',
                                            data: {
                                                role: $('#productName').val(),
                                                difficulty: document.getElementById("difficulty").value,
                                                title: document.getElementById("title").value,
                                                tags: document.getElementById("tags").value,
                                                description: document.getElementById("description").value
                                            },
                                            datatype: 'json'
                                        });
                                    }
                                });
                            });

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

                        <div id="uploader">You browser doesn't have HTML 4 support.</div>

                        {!! Form::close()  !!}

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
