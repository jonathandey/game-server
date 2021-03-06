@extends('game.layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<div class="panel-heading">My Vehicles</div>
            	<div class="panel-body">
					@if (session('message'))
						<p>
							<strong>{!! session('message') !!}</strong>
						</p>
					@endif
					<form action="/vehicles" method="POST">
						{{ csrf_field() }}
						<div class="btn-group" role="group" aria-label="Manage vehicles">
							<input type="submit" name="drop" value="Drop" class="btn btn-default">
							<input type="submit" name="sell" value="Sell" class="btn btn-default">
							<input type="submit" name="repair" value="Repair" class="btn btn-default">
							<input type="submit" name="secure" value="Secure" class="btn btn-default">
							<input type="submit" name="park" value="Park" class="btn btn-default">
						</div>
						<hr />
						<div class="table-responsive" style="max-height: 900px">
							<table class="table table-striped table-bordered table-hover">
								<tr>
									<th></th>
									<th>Type</th>
									<th>Damage</th>
									<th>Value</th>
								</tr>
								@forelse($stolenVehicles as $stolenVehicle)
									<tr class="@if ($stolenVehicle->isGaraged()) success @endif">
										<td>
											<input type="checkbox"
												name="selected[]" 
												value="{{ $stolenVehicle->getKey() }}">
										</td>
										<td>
											{{ $stolenVehicle->presenter()->make() }}
											@if ($stolenVehicle->isGaraged())
												<em title="This vehicle has been secured. It cannot be sold, or found by the police.">(Secured)</em>
											@endif
										</td>
										<td>
											{{ $stolenVehicle->presenter()->damage() }}
										</td>
										<td>
											{{ $stolenVehicle->presenter()->valueWithSymbol() }}
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="10">
											<p class="text-center">You haven't stolen any vehicles yet.</p>
										</td>
									</tr>
								@endforelse
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection