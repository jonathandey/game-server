@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		@include('game.shared.messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				Your Profile (<a href="{{ $player->presenter()->profileUrl() }}">View profile</a>)
			</div>
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading">
						Profile quote:
					</div>
					<div class="panel-body">
						<form action="/profile/update/quote" method="POST">
							{{ csrf_field() }}
							<div class="form-group">
								<textarea name="quote" id="profileQuote" rows="10" class="form-control">{{ $player->quote }}</textarea>
							</div>
							<button class="btn btn-primary btn-block" type="submit">Update</button>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Change your password:
							</div>
							<div class="panel-body">
								<form action="/profile/update/password" method="POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="profileCurrentPassword">Current Password:</label>
										<input type="password" name="current_password" class="form-control">
									</div>
									<div class="form-group">
										<label for="profileNewPassword">New Password:</label>
										<input type="password" name="new_password" class="form-control">
									</div>
									<div class="form-group">
										<label for="profileNewPasswordConfirmed">New Password Again:</label>
										<input type="password" name="new_password_confirmation" class="form-control">
									</div>
									<button class="btn btn-primary btn-block" type="submit">Change</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection