@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $user->name }}'s Profile
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>Username:</td>
							<td>{{ $user->name }} (<em>{{ $user->presenter()->presence() }}</em>)</td>
						</tr>
						<tr>
							<td>Wealth Status:</td>
							<td>{{ $user->wealthStatus }}</td>
						</tr>
						<tr>
							<td>Joined:</td>
							<td>{{ $user->created_at->format('Y-m-d h:i') }}</td>
						</tr>
						<tr>
							<td colspan="2">
								No quote
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection