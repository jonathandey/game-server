var Countdown = function(hour, minute, second, cb) {
	this.hour = parseInt(hour);
	this.minute = parseInt(minute);
	this.second = parseInt(second);

	this.interval = null;

	this.cb = cb;

	this.startCountdown();
}

Countdown.prototype.startCountdown = function() {
	this.interval = setInterval($.proxy(this.count, this), 1000);
}

Countdown.prototype.count = function() {
	--this.second;

	if (this.second < 0) {
		this.second = 59;

		--this.minute;

		if (this.minute < 0) {
			this.minute = 59;

			--this.hour;

			if (this.hour < 0) {
				this.hour = 0
				this.minute = 0
				this.second = 0
			}
		}
	}

	if (this.hour > 0 ||
		this.minute > 0 ||
		this.second > -1) {
		this.cb(this)
	}
}

$(function() {
	$('.timer > .countdown').each(function () {
		var $this = $(this),
			timer = $this.text();

		var timerParts = timer.trim().split(':');
		new Countdown(timerParts[0], timerParts[1], timerParts[2], function(timer) {
			var hour = (timer.hour > 9) ? timer.hour : '0' + timer.hour;
			var minute = (timer.minute > 9) ? timer.minute : '0' + timer.minute;
			var second = (timer.second > 9) ? timer.second : '0' + timer.second;

			var text = hour + ':' + minute + ':' + second;

			if (text == '00:00:00') {
				text = 'Ready!';
			}

			$this.text(text)
		});
	});
});