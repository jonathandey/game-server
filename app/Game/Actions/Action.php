<?php

namespace App\Game\Actions;

use App\Game\Game;
use App\Game\Player;
use Illuminate\Database\Eloquent\Model;

abstract class Action extends Model
{
	const MESSAGE_ATTRIBUTE_SUCCESSFUL = 'successful';

	const MESSAGE_ATTRIBUTE_FAILED = 'failed';

	protected $player = null;

	protected $successful = false;

	protected $successfulMessage = 'Successful!';

	protected $failedMessage = 'Failed!';

	protected $awards = null;

	protected $maxChancePercentage = 100;

	public $timestamps = false;

	public function failed()
	{
		return ! $this->successful;
	}

	public function successful()
	{
		return $this->successful;
	}

	public function awards($awards = null)
	{
		if (is_null($awards)) {
			return $this->awards;
		}

		$this->awards = $awards;

		return $this;
	}

	public function successfulMessage($successfulMessage = null)
	{
		if (is_null($successfulMessage)) {
			return $this->successfulMessage;
		}

		$this->successfulMessage = $successfulMessage;

		return $this;
	}

	public function failedMessage($failedMessage = null)
	{
		if (is_null($failedMessage)) {
			return $this->failedMessage;
		}

		$this->failedMessage = $failedMessage;

		return $this;
	}

	public function outcomeMessage()
	{
		$message = $this->failedMessage();

		if ($this->successful()) {
			$message = $this->successfulMessage();
		}

		return $message;
	}

	public function player(Player $player = null)
	{
		if (is_null($player)) {
			return $this->player;
		}

		$this->player = $player;

		return $this;
	}

	public function as(Player $player = null)
	{
		return $this->player($player);
	}

	public function for(Player $player = null)
	{
		return $this->player($player);
	}

	protected function successfulAttempt()
	{
		$this->successful = true;
	}

	protected function skilledAttempt()
	{
		$percentage = $this->skillPercentageChance();
		$diceResult = app(Game::class)->dice()->roll();

		$this->successful = false;

		if ($diceResult <= $percentage) {
			$this->successful = true;
		}
	}

	public function skillPercentageChance()
	{
		$difficulty = $this->difficulty();
		$skill = $this->playerSkill();

		if ($skill <= 0) {
			return $skill;
		}

		$adjustment = $skill / $difficulty;
		$difficultyAdjustment = 1. / ($adjustment * $adjustment);

		$chance = $difficulty * $difficultyAdjustment;

		if ($skill <= 0) {
			return $skill;
		}

		$percentage = round(($skill / $chance) * 100, 2, PHP_ROUND_HALF_UP);

		$percentage = ($percentage > $this->maxChancePercentage) ? $this->maxChancePercentage : $percentage;
		$percentage = ($percentage < 0) ? 0 : $percentage;

		$randAdjustment = 55 - ($adjustment * 50);
		$randAdjustment = ($randAdjustment < 8) ? 8 : $randAdjustment;
		// Need to store this random number to ensure the % doesn't always change on page refresh
		$randAdjustment = mt_rand(0, $randAdjustment);
		$randAdjustmentPercentage = $randAdjustment / 100;

		$finalPercentage = (1 - $randAdjustmentPercentage) * $percentage;

		return round($finalPercentage);	
	}

	protected function playerSkill()
	{
		return $this->player()->attribute->crime_skill;
	}
}