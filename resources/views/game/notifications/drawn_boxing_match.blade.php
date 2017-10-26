<li class="list-group-item @if($notification->unread()) list-group-item-info @endif">
	<p>
		It was a tough fight. Neither of you came out looking good. You got @money($notification->data['monetary_reward']) after fees.
	</p>
	<em style="font-size: 11px;">{{ $notification->updated_at->format('d/m/Y H:i') }}</em>
</li>