@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @foreach ($videos as $video)
						<iframe width="420" height="315"
							src="https://www.youtube.com/embed/{{ $video['video_id'] }}">
						</iframe>
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
