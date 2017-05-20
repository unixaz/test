@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Rakto generavimas</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        Jūsų registracijos raktas
                        @if (Auth::user()->role == 2)
                            dėstytojui:
                         @elseif (Auth::user()->role == 1)
                            studentui:
                        @endif

                        @if (!empty($regkey))
                            <b> {{ $regkey->regkey }} </b>
                        @endif
                        <br>
                        <br>
                        <a href="{{ url('generateKey2') }}" class="btn btn-primary " role="button">Generuoti raktą</a>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
