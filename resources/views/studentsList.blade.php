@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Studentų sąrašas</b></div>
                    <div class="panel-body">

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Grupė</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($groups as $group)

                                            <tr>
                                                <td><a href="{{ url('studentsList2/' . $group['id']) }}">{{ $group['group'] }}</a></td>
                                                </a>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

