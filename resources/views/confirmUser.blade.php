@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Patvirtinti vartotojus</b></div>
                    <div class="panel-body">

                        @include('flash::message')

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Vardas Pavardė</th>
                                    <th>Pareigos</th>
                                    <th>El. Paštas</th>
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

                                        <td><a href="{{ url('/confirmUser2/add',$user->id) }}" class="btn btn-success" role="button">Patvirtinti</a>
                                            <a href="{{ url('/confirmUser2/del',$user->id) }}" class="btn btn-danger" role="button">Ištrinti</a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
