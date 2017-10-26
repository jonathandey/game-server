<li class="list-group-item @if($notification->unread()) list-group-item-success @endif">
	<p>You took a real beating kid. Your opponent won the fight and went home with @money($notification->data['monetary_reward'])</p>
	<em style="font-size: 11px;">{{ $notification->updated_at->format('d/m/Y H:i') }}</em>
</li>