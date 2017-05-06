@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Keisti vaizdo įrašų pozicijas grojaraštyje</b></div>
                    <div class="panel-body">

                        <div id="response"></div>

                        <label for="playlist" class="col-lg-2 control-label">Jūsų vaizdo įrašai</label>
                        <div class="col-lg-10">
                            Paspauskite ant video elemento ir tempkite jį aukštyn/žemym norint keisti poziciją
                            <ul id="sortable">
                                @foreach ($videos as $video)
                                    <div class="panel panel-default ui-state-default" data-id="{!! $video['id'] !!}" >
                                        <div class="panel-body">
                                            {!! $video['title'] !!}
                                        </div>
                                    </div>

                                @endforeach
                        </ul>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" id="save-reorder" class="btn btn-primary">Saugoti pozicijas</button>
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
                url: '/bakalauras/public/changeVideoOrder3',
                type: 'POST',
                data: {
                    playlist_id:'<?php echo $id; ?>',
                    rearranged_list:data,
                }, // data to send in ajax format or querystring format
                datatype: 'json',
                success: function(data){
                    if(data.resp){
                        $('#response').html('<div class="alert alert-info col-ssm-12" >' + data.message + '</div>');
                    }else{
                        $('#response').html('<div class="alert alert-info col-ssm-12" >' + data.message + '</div>');
                    }


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

