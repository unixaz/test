@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>


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

                    {!! Form::open(['url' => '/assignPlaylist', 'class' => 'form-horizontal']) !!}

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

                    <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Pavadinimas</th>
                            <th>Grojaraštis</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($videos as $video)
                            <tr>
                                <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                @foreach ($video->playlist as $playlist)
                                    <td> {!! $playlist->title !!} </td>
                                @endforeach
                            <br>
                                {{--$video['playlist_id']--}}
                        @endforeach
                        </tbody>
                    </table>
                    </div>


                    <div class="form-group">
                        {!! Form::submit('Kurti Skelbimą',
                          array('class'=>'btn btn-primary')) !!}
                    </div>

                    {!! Form::close()  !!}

                    <ul id="sortable">
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
                    </ul>

                </div>
            </div>
        </div>



    </div>




    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sortable/0.8.0/js/sortable.min.js"></script>

    <script>
        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );
    </script>

@endsection

