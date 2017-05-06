@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">

            @include('leftNavbar')

            <div class="col-xs-12 col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Keisti vaizdo įrašo savininką</b></div>
                    <div class="panel-body">

                        @include('flash::message')
                        @include('errors')

 {!! Form::open(['url' => '/changeOwner', 'class' => 'form-horizontal']) !!}
     <fieldset>

         {{ ($errors->has('professor')) ? $errors->first('professor') : '' }}
         <div class="form-group">
             <label for="professor" class="col-lg-2 control-label">Naujas savininkas</label>
             <div class="col-lg-10">
                 <select name="professor" class="form-control">
                     @foreach ($professors as $professor)
                         <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                     @endforeach
                 </select>
             </div>
         </div>

         <div class="form-group">
             <label for="title" class="col-lg-2 control-label">Vaizdo įrašai</label>
             <div class="col-lg-10">
                 <table class="table table-bordered">
                     <thead>
                     <tr>
                         <th>Pavadinimas</th>
                         <th>Savininkas</th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach ($videos as $video)
                         <tr>
                             <td> {!! Form::checkbox('ch[]', $video['id'], false) !!} {!! Form::label($video['title']) !!}</td>
                             @foreach ($video->users as $users)
                                 <td>{{ $users->name }}</td>
                             @endforeach
                     @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <div class="form-group">
             <div class="col-lg-10 col-lg-offset-2">
                 <button type="submit" class="btn btn-primary">Keisti savininką</button>
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

