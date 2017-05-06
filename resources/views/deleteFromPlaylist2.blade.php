@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Pašalinti video iš grojaraščio</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

                    {!! Form::open(['url' => '/deleteFromPlaylist3/' . $playlist->id, 'class' => 'form-horizontal']) !!}
                        <fieldset>

                            <div class="form-group">
                                <label for="title" class="col-lg-2 control-label">Video grojaraštyje</label>
                                <div class="col-lg-10">
                                    Pasirinkite kokius video norite pašalinti iš grojaraščio "{{ $playlist->title }}"
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($videos as $video)
                                            <tr>
                                                <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Išvalyti formą</button>
                                    <button type="submit" class="btn btn-primary">Ištrinti iš grojaraščio</button>
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

