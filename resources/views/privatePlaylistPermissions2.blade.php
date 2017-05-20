@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Privačių grojaraščių teisės</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/privatePlaylistPermissions3/' . $id, 'class' => 'form-horizontal']) !!}
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
                                <label for="title" class="col-lg-2 control-label">Grupių teisės</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Grupė</th>
                                            <th>Teisės</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($groups as $key => $group)
                                            <tr>
                                                <td> {!! Form::checkbox('ch[]', $group['id'], false) !!} {!! Form::label($group['group']) !!}</td>

                                                    <td>
                                                        @foreach ($playlists as $playlist)
                                                            @if ($playlist->group_id == $group['id'])
                                                                Mato grojaraštį
                                                                @break
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

