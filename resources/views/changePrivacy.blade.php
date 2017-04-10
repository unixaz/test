@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Keisti video privatumą</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/changePrivacy', 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            {{ ($errors->has('privacy')) ? $errors->first('privacy') : '' }}
                            <div class="form-group">
                                <label for="privacy" class="col-lg-2 control-label">Privatumas</label>
                                <div class="col-lg-10">
                                    <select name="privacy" class="form-control">

                                        <option value="public">Viešas</option>
                                        <option value="unlisted">Privatus</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Jūsų video</label>
                                <div class="col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                            <th>Privatumas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($videos as $video)
                                            <tr>
                                                <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                                @if ($video['privacy'] == 'public')
                                                    <td>Viešas</td>
                                                @elseif($video['privacy'] == 'unlisted')
                                                    <td>Privatus</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary">Keisti privatumą</button>
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

