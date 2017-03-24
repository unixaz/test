@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @foreach ($video as $videos)
						<iframe width="420" height="315"
							src="https://www.youtube.com/embed/{{ $videos['video_id'] }}">
						</iframe>
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
