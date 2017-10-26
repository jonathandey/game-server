<li class="list-group-item @if($notification->unread()) list-group-item-success @endif">
	<p>You won your boxing match! You were awarded @money($notification->data['monetary_reward']) before fees.</p>
	<em style="font-size: 11px;">{{ $notification->updated_at->format('d/m/Y H:i') }}</em>
</li>