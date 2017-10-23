@extends('game.layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<div class="panel-heading">Street Crime</div>
            	<div class="panel-body">
					@if (session('message'))
						{!! session('message') !!}
					@endif
					@if (isset($timer))
						<div class="alert alert-info text-center">
							<p>You are recovering from you previous attempt...</p>
							<div class="timer">
								<strong class="countdown">{{ $timer }}</strong>
							</div>
						</div>
					@endif
					<form action="/crimes" method="POST">
						{{ csrf_field() }}
						<ul class="list-unstyled">
							@foreach ($actions as $crime)
								<li>
									<div class="radio">
										<label for="crime-{{ $loop->index }}">
											<input type="radio" 
												name="crime" 
												value="{{ $loop->index }}" 
												id="crime-{{ $loop->index }}">
											{{ $crime->name() }} ({{ $crime->percentage() }}%)
										</label>
									</div>
								</li>
							@endforeach
						</ul>
						<button type="submit" class="btn btn-block btn-primary">Commit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection