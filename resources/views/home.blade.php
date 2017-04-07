@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Naujienos</b></div>
                    <div class="panel-body">

                        @foreach($info as $infos)
                            <b> {{ $infos->title }}</b>
                            {!! $infos->description !!}
                            <small>{{ $infos->created_at->diffForHumans() }}</small>
                            <hr>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
