@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-8">
		<ul class="list-group">
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
	<div class="col-md-8">
		{{ $notifications->links() }}
	</div>
</div>
@endsection