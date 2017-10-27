@if (isset($timer))
	<div class="alert alert-info text-center">
		<p>{{ $message }}</p>
		<div class="timer">
			<strong class="countdown">{{ $timer }}</strong>
		</div>
	</div>
@endif