@extends('layouts.app')

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Šalinti vaizdo įrašus</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/deleteVideo', 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            {{ ($errors->has('videos')) ? $errors->first('videos') : '' }}

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Vaizdo įrašai</label>
                                <div class="col-lg-10">
                                    <div class="form-group">
                                            <select class="productName form-control" name="productName[]" id="productName" multiple="multiple"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Šalinti vaizdo įrašus</button>
                                </div>
                            </div>

                        </fieldset>
                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $( ".productName" ).select2({
            ajax: {
                url: "ajax/videosList",
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
@endsection

