@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Vartotojų šalinimas</b></div>
                    <div class="panel-body">

                        <label for="playlist" class="col-lg-2 control-label">Grupės</label>
                        <div class="col-lg-10">

                        <div class="list-group">
                            <a href="{{ url('deleteUsers2/0') }}" class="list-group-item">
                                <i class="fa fa-comment fa-fw"></i> Dėstytojai
                            </a>
                                @foreach($groups as $key=>$group)

                                    <a href="{{ url('deleteUsers2/' . $group->id) }}" class="list-group-item">
                                        <i class="fa fa-comment fa-fw"></i> {{ $group->group }}
                                    </a>

                                @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
