@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		@include('game.shared.messages')
		@include('game.shared.timer', ['message' => 'The next train is due in...'])
		<div class="panel panel-default">
			<div class="panel-heading">
				Train Station
			</div>
			<div class="panel-body">
				<form action="/travel" method="POST">
					{{ csrf_field() }}
					<div class="row">
						@foreach ($destinations as $destination)
							<div class="col-md-6">
								<div class="panel panel-info">
									<div class="panel-heading">
										{{ $destination->name() }}
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label style="font-weight: normal; display: block;">
												<p>
													Ticket price: @money($destination->price())
												</p>
												<p>
													Population: {{ $destination->population() }}
												</p>
												<p class="text-center">
													<input type="radio" 
														name="destination" 
														value="{{ $destination->id() }}">
												</p>
											</label>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<button class="btn btn-primary btn-block">
						Travel
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection