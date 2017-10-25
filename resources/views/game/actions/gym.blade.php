@extends('game.layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<div class="panel-heading">Gymnasium</div>
            	<div class="panel-body">
					@if (session('message'))
						{!! session('message') !!}
					@endif
					@if (isset($timer))
						<div class="alert alert-info text-center">
							<p>You are recovering from you previous session...</p>
							<div class="timer">
								<strong class="countdown">{{ $timer }}</strong>
							</div>
						</div>
					@endif
					<form action="/gym" method="POST">
						{{ csrf_field() }}
						<div class="workout-group">
							<h4>Strength Training</h4>
							<ul class="list-unstyled">
								@foreach ($actions[1] as $workout)
									<li>
										<div class="radio">
											<label for="workout-{{ $workout->getKey() }}">
												<input type="radio" 
													name="workout" 
													value="{{ $workout->getKey() }}" 
													id="workout-{{ $workout->getKey() }}">
												{{ $workout->name }} ({{ $workout->presenter()->skillPointsWithSymbol() }})
											</label>
										</div>
									</li>
								@endforeach
							</ul>
							<div>
								<p><strong>Level:</strong> {{ $action->presenter()->playerStrengthLevel() }}</p>
								<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerStrengthProgress() }} / {{ $action->presenter()->playerStrengthProgressGoal() }}</p>
							</div>
							<hr>
						</div>
						<div class="workout-group">
							<h4>Stamina Training</h4>
							<ul class="list-unstyled">
								@foreach ($actions[2] as $workout)
									<li>
										<div class="radio">
											<label for="workout-{{ $workout->getKey() }}">
												<input type="radio" 
													name="workout" 
													value="{{ $workout->getKey() }}" 
													id="workout-{{ $workout->getKey() }}">
												{{ $workout->name }} ({{ $workout->presenter()->skillPointsWithSymbol() }})
											</label>
										</div>
									</li>
								@endforeach
							</ul>
							<div>
								<p><strong>Level:</strong> {{ $action->presenter()->playerStaminaLevel() }}</p>
								<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerStaminaProgress() }} / {{ $action->presenter()->playerStaminaProgressGoal() }}</p>
							</div>
							<hr>
						</div>
						<div class="workout-group">
							<h4>Agility Training</h4>
							<ul class="list-unstyled">
								@foreach ($actions[3] as $workout)
									<li>
										<div class="radio">
											<label for="workout-{{ $workout->getKey() }}">
												<input type="radio" 
													name="workout" 
													value="{{ $workout->getKey() }}" 
													id="workout-{{ $workout->getKey() }}">
												{{ $workout->name }} ({{ $workout->presenter()->skillPointsWithSymbol() }})
											</label>
										</div>
									</li>
								@endforeach
							</ul>
							<div>
								<p><strong>Level:</strong> {{ $action->presenter()->playerAgilityLevel() }}</p>
								<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerAgilityProgress() }} / {{ $action->presenter()->playerAgilityProgressGoal() }}</p>
							</div>
							<hr>
						</div>
						<button type="submit" class="btn btn-block btn-primary">Train</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection