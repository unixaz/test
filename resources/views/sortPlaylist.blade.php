@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Naujienos</b></div>
                    <div class="panel-body">

                        <ul id="sortable">
                        @foreach ($videos as $video)
                                <div class="panel panel-default ui-state-default" data-id="{!! $video['id'] !!}" >
                                    <div class="panel-body">
                                        {!! $video['title'] !!}
                                    </div>
                                </div>
                              {{--  <li data-id="{!! $video['id'] !!}" class="ui-state-default">{!! $video['title'] !!}</li>--}}
                        @endforeach
                        </ul>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button id="save-reorder" class="btn btn-primary">Saugoti</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $(document).ready(function(){
        $(document).on('click','#save-reorder',function(){
            var list = [];
            $('#sortable').find('.ui-state-default').each(function(){
                var id=$(this).attr('data-id');
                list.push(id);
            });
            var data=list;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'sortPlaylist2', // server url
                type: 'POST', //POST or GET
                data: {
                    playlist_id:'<?php echo $playlist_id; ?>',
                    rearranged_list:data
                }, // data to send in ajax format or querystring format
                datatype: 'json',
                success: function(message) {

                }

            });
        });

    });

</script>

    <script>
        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );
    </script>

@endsection

