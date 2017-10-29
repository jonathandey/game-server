@extends('game.layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-default">
        	<div class="panel-heading">Street Crime</div>
        	<div class="panel-body">
        		@include('game.shared.messages')
				@include('game.shared.timer', ['message' => 'You are recovering from you previous attempt...'])
				<form action="/crimes" method="POST">
					{{ csrf_field() }}
					<ul class="list-unstyled">
						@foreach ($actions as $crime)
							<li>
								<div class="radio">
									<label for="crime-{{ $crime->getKey() }}">
										<input type="radio" 
											name="crime" 
											value="{{ $crime->getKey() }}" 
											id="crime-{{ $crime->getKey() }}">
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
@endsection