@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Grupių administravimas</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        {!! Form::open(['url' => '/addGroup', 'class' => 'form-inline']) !!}

                        <div class="form-group">
                            <label for="group" class="col-lg-2 control-label">Grupė</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="group">
                                <button type="submit" class="btn btn-primary">Pridėti grupę</button>
                            </div>
                        </div>

                    {!! Form::close()  !!}
<br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Grupė</th>
                                    <th>Veiksmas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)

                                    <tr>
                                        <td> {{ $group->id }}</td>
                                        <td> {{ $group->group }}</td>
                                        <td>
                                            <a href="{{ url('/deleteGroup',$group->id) }}" class="btn btn-danger btn-sm" role="button">Šalinti</a>
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
