@extends('game.layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-default">
        	<div class="panel-heading">Auto Burglary</div>
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
				<form action="/autoburglary" method="POST">
					{{ csrf_field() }}
					<ul class="list-unstyled">
						@foreach ($actions as $autoBurglary)
							<li>
								<div class="radio">
									<label for="autoBurglary-{{ $autoBurglary->getKey() }}">
										<input type="radio" 
											name="autoBurglary" 
											value="{{ $autoBurglary->getKey() }}" 
											id="autoBurglary-{{ $autoBurglary->getKey() }}">
										{{ $autoBurglary->name }} ({{ $autoBurglary->percentage() }}%)
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
@endsection