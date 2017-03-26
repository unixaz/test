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
                                @foreach($info as $infos)
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-comment fa-fw"></i> {{ $infos->title }}
                                        {!! $infos->description !!}
                                        <span class="pull-right text-muted small"><em>{{ $infos->created_at->diffForHumans() }}</em></span>
                                        <br>
                                    </a>
                                @endforeach
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
