@extends('layouts.app')

@section('content')

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
                            <label for="role">Dėstytojas:</label>
                            <select name="role"id="role" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
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
                                                role: document.getElementById("role").value,
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
                        </script>

                        <div id="uploader">You browser doesn't have HTML 4 support.</div>

                        {!! Form::close()  !!}

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
