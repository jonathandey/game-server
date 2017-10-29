@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		<ul class="list-group">
			<li class="list-group-item disabled">
				Notifications
			</li>
			@forelse($notifications as $notification)
				@include(
					'game.notifications.'.snake_case(class_basename($notification->type)),
					$notification
				)
			@empty
				<li class="list-group-item">
					<em>You have no notifications</em>
				</li>
			@endforelse
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		{{ $notifications->links() }}
	</div>
</div>
@endsection