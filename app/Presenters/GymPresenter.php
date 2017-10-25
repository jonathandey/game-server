<?php

namespace App\Presenters;

use App\PlayerAttribute;
use App\Game\Actions\Gym\Gym;

class GymPresenter extends ActionPresenter
{
	protected $unformattedSuccessMessage = 'Nice work! You gained %s %s.';

	protected function outcomeMessageAttributes()
	{
		$attributes = [
			'+' . $this->action->awards()->first(),
		];

		if ($this->action->{Gym::ATTRIBUTE_TYPE} == Gym::TYPE_STRENGTH) {
			$attributes[] = 'strength';
		}

		if ($this->action->{Gym::ATTRIBUTE_TYPE} == Gym::TYPE_STAMINA) {
			$attributes[] = 'stamina';
		}

		if ($this->action->{Gym::ATTRIBUTE_TYPE} == Gym::TYPE_AGILITY) {
			$attributes[] = 'agility';
		}

		return $attributes;
	}

	public function skillPoints()
	{
		return $this->action->{Gym::ATTRIBUTE_SKILL_POINTS};
	}

	public function skillPointsWithSymbol()
	{
		return sprintf("+%d", $this->skillPoints());
	}

	public function playerStrengthLevel()
	{
		return $this->playerLevel(Gym::TYPE_STRENGTH);
	}

	public function playerStaminaLevel()
	{
		return $this->playerLevel(Gym::TYPE_STAMINA);
	}

	public function playerAgilityLevel()
	{
		return $this->playerLevel(Gym::TYPE_AGILITY);
	}

	public function playerStrengthProgress()
	{
		return $this->playerProgress(Gym::TYPE_STRENGTH);
	}

	public function playerStaminaProgress()
	{
		return $this->playerProgress(Gym::TYPE_STAMINA);
	}

	public function playerAgilityProgress()
	{
		return $this->playerProgress(Gym::TYPE_AGILITY);
	}

	public function playerStrengthProgressGoal()
	{
		return $this->playerProgressGoal(Gym::TYPE_STRENGTH);
	}

	public function playerStaminaProgressGoal()
	{
		return $this->playerProgressGoal(Gym::TYPE_STAMINA);
	}

	public function playerAgilityProgressGoal()
	{
		return $this->playerProgressGoal(Gym::TYPE_AGILITY);
	}

	protected function playerLevel($for)
	{
		if ($for == Gym::TYPE_STRENGTH) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STRENGTH_LEVEL};
		}

		if ($for == Gym::TYPE_STAMINA) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STAMINA_LEVEL};
		}

		if ($for == Gym::TYPE_AGILITY) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_AGILITY_LEVEL};
		}
	}

	protected function playerProgress($for)
	{
		if ($for == Gym::TYPE_STRENGTH) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STRENGTH_PROGRESS};
		}

		if ($for == Gym::TYPE_STAMINA) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STAMINA_PROGRESS};
		}

		if ($for == Gym::TYPE_AGILITY) {
			return $this->player()->attribute->{PlayerAttribute::ATTRIBUTE_GYM_AGILITY_PROGRESS};
		}
	}

	protected function playerProgressGoal($for)
	{
		if ($for == Gym::TYPE_STRENGTH) {
			return $this->player()->attribute->strengthTarget();
		}

		if ($for == Gym::TYPE_STAMINA) {
			return $this->player()->attribute->staminaTarget();
		}

		if ($for == Gym::TYPE_AGILITY) {
			return $this->player()->attribute->agilityTarget();
		}
	}
}