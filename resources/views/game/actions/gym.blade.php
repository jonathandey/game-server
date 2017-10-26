@extends('game.layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
        	<div class="panel-heading">Gymnasium</div>
        	<div class="panel-body">
				@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
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
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Strength Training: 
								<strong>Level: {{ $action->presenter()->playerStrengthLevel() }}</strong>
							</div>
							<div class="panel-body">
								<form action="/gym" method="POST">
									{{ csrf_field() }}
									<div class="workout-group">
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
										<hr>
										<div>
											<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerStrengthProgress() }} / {{ $action->presenter()->playerStrengthProgressGoal() }}</p>
											<div class="progress">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$action->presenter()->playerStrengthProgressPercentage()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$action->presenter()->playerStrengthProgressPercentage()}}%;">
													<span class="sr-only">{{$action->presenter()->playerStrengthProgressPercentage()}}% Complete</span>
												</div>
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-block btn-primary">Train</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Stamina Training
								<strong>Level: {{ $action->presenter()->playerStaminaLevel() }}</strong>
							</div>
							<div class="panel-body">
								<form action="/gym" method="POST">
									{{ csrf_field() }}
									<div class="workout-group">
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
										<hr>
										<div>
											<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerStaminaProgress() }} / {{ $action->presenter()->playerStaminaProgressGoal() }}</p>
											<div class="progress">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$action->presenter()->playerStaminaProgressPercentage()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$action->presenter()->playerStaminaProgressPercentage()}}%;">
													<span class="sr-only">{{$action->presenter()->playerStaminaProgressPercentage()}}% Complete</span>
												</div>
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-block btn-primary">Train</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Agility Training:
								<strong>Level: {{ $action->presenter()->playerAgilityLevel() }}</strong>
							</div>
							<div class="panel-body">
								<form action="/gym" method="POST">
									{{ csrf_field() }}
									<div class="workout-group">
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
										<hr>
										<div>
											<p><strong>Progress to next level:</strong> {{ $action->presenter()->playerAgilityProgress() }} / {{ $action->presenter()->playerAgilityProgressGoal() }}</p>
											<div class="progress">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$action->presenter()->playerAgilityProgressPercentage()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$action->presenter()->playerAgilityProgressPercentage()}}%;">
													<span class="sr-only">{{$action->presenter()->playerAgilityProgressPercentage()}}% Complete</span>
												</div>
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-block btn-primary">Train</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Fist Fight
							</div>
							<div class="panel-body">
								<form action="/gym/fight" method="POST">
									{{ csrf_field() }}
									<p class="text-danger" style="font-size: 11px">A 5% match fee is deducted from fight winnings</p>
									<div class="form-group">
										<input type="text" class="form-control" name="taunt" placeholder="Taunt...">
									</div>
									<div class="form-group">
										<input type="number" class="form-control" name="monetary_stake" placeholder="Monetry Stake">
									</div>
									<button type="submit" class="btn btn-block btn-primary">Post Fight</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-2">
		<div class="panel panel-default">
			<div class="panel-heading">Posted Fights</div>
			<div class="panel-body">
				@forelse ($fights as $fight)
					<div class="panel panel-info">
						<div class="panel-heading">{{ $fight->presenter()->originator() }}</div>
						<div class="panel-body">
							@if ($fight->presenter()->hasTaunt())
								<em style="text-align: center;">{{ $fight->presenter()->taunt() }}</em>
							@endif
							<p>
								<strong>Stake:</strong> {{ $fight->presenter()->monetaryStakeWithSymbol() }}
							</p>
							<form action="/gym/fight/match" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="fight_id" value="{{ $fight->getKey() }}">
								<input type="submit" name="fight" class="btn btn-default btn-block" value="Fight!">
								@if ($fight->presenter()->isPlayersMatch())
									<input type="submit" name="cancel" class="btn btn-warning btn-block" value="Back Down">
								@endif
							</form>
						</div>
					</div>
				@empty
					<em class="text-center">No one has posted a fight</em>
				@endforelse
			</div>
		</div>
	</div>
</div>
@endsection