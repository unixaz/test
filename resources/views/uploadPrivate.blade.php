@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Įkelti privatų vaizdo įrašą</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                        {!! Form::open(['url' => '/uploadPrivate2', 'class' => 'form-horizontal', 'enctype' => "multipart/form-data"]) !!}

                        <div class="form-group">
                            <label for="role">Dėstytojas:</label>
                            <select name="role" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="difficulty">Sudėtingumas:</label>
                            <select name="difficulty" class="form-control">
                                <option value="1">Labai lengvas</option>
                                <option value="2">Lengvas</option>
                                <option value="3">Vidutinis</option>
                                <option value="4">Sudėtingas</option>
                                <option value="5">Labai sudėtingas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Pavadinimas:</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label for="tags">Raktažodžiai:</label>
                            <input type="text" class="form-control" name="tags">
                        </div>
                        <div class="form-group">
                            <label for="description">Aprašymas:</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                            <label class="btn btn-default btn-file">
                                <input type="file" name="file" accept="video/*" hidden>
                            </label>
                        <button type="submit" class="btn btn-primary">Įkelti vaizdo įrašą</button>

                        {!! Form::close()  !!}

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
