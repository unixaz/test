@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Vartotojų/grupių importavimas</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        {!! Form::open(['url' => '/importUsers2', 'class' => 'form-horizontal', 'files' => true]) !!}

                        Pasirinkite XML failą su vartotojų duomenimis
                        <br>
                        <br>
                        {{Form::file('xml_file')}}
                        <br>
                        {{Form::submit('Importuoti vartotojus', ['class' => 'btn btn-success'])}}

                        {{Form::close()}}
<hr>
                        {!! Form::open(['url' => '/importUsers3', 'class' => 'form-horizontal', 'files' => true]) !!}

                        Pasirinkite XML failą su grupių duomenimis
                        <br>
                        <br>
                        {{Form::file('group_xml_file')}}
                        <br>
                        {{Form::submit('Importuoti grupes', ['class' => 'btn btn-success'])}}

                        {{Form::close()}}

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
