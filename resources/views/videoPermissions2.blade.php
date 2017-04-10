@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Privačių video teisės</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/videoPermissions3/' . $id, 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            {{ ($errors->has('privacy')) ? $errors->first('privacy') : '' }}
                            <div class="form-group">
                                <label for="privacy" class="col-lg-2 control-label">Veiksmas</label>
                                <div class="col-lg-10">
                                    <select name="privacy" class="form-control">

                                        <option value="1">Suteikti teisę</option>
                                        <option value="0">Atimti teisę</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Vartotojai</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Vardas Pavardė</th>
                                            <th>Teisės</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td> {!! Form::checkbox('ch[]', $user['id'], false) !!} {!! Form::label($user['name']) !!}</td>

                                                    <td>
                                                        @foreach ($user->permission as $permission)
                                                            @if ($permission->video_id == $id)

                                                                Mato video
                                                            @endif
                                                        @endforeach
                                                    </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary">Nustatyti teises</button>
                                </div>
                            </div>

                        </fieldset>
                    {!! Form::close()  !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

