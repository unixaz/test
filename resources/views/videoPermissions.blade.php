@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Privačių vaizdo įrašų teisės</b></div>
                    <div class="panel-body">

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Jūsų privatūs vaizdo įrašai</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($videos as $video)

                                            <tr>
                                                <td><a href="{{ url('videoPermissions2/' . $video['id']) }}">{{ $video['title'] }}</a></td>

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

