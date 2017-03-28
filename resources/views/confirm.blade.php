@extends('layouts.app')

@section('content')
    <div id="wrapper">

        <!-- Navigation -->

        @include('leftNavbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">


                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Veiksmas</th>
                                    </tr>
                                    </thead>
                                    <tbody>





                                @foreach($users as $user)
                                    <tr>
                                        <td> {{ $user->name }}</td>

                                        @if ($user->role == 0)
                                            <td>Studentas</td>
                                        @elseif ($user->role == 1)
                                            <td>Dėstytojas</td>
                                        @else
                                            <td>Nerasta</td>
                                        @endif
                                        <td> {{ $user->email }}</td>

                                        <td><a href="{{ url('/confirm2/add',$user->id) }}" class="btn btn-success" role="button">Patvirtinti</a>
                                            <a href="{{ url('/confirm2/del',$user->id) }}" class="btn btn-danger" role="button">Ištrinti</a>
                                        </td>
                                    </tr>

                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-3">

                    <div id="my-calendar"></div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@endsection
