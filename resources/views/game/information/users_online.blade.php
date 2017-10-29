@extends('game.layouts.dashboard')

@section('content')
<div class="row">
	<div class="col-md-9 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Users online</div>
			<div class="panel-body">
				<div class="online-users" style="padding: 10px 10px 30px">
					@forelse ($onlineUsers as $user)
						{!! $user->presenter()->profileLink() !!}
						(<em>{{$user->presenter()->presence()}}</em>)
						@if(! $loop->last) - @endif
					@empty
						<em>No users online</em>
					@endforelse
				</div>
				<p class="text-center">Total online: {{ count($onlineUsers) }}</p>
			</div>
		</div>
	</div>
</div>
@endsection