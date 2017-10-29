<?php

namespace App\Game\Actions\Gym;

use App\User;
use App\Game\Game;
use App\BoxingMatch;
use App\PlayerAttribute;

// Boxing match
// Skill = 100 / (strength / stamina) * agility
// Player 1:
// Strength: 5, Stamina: 2, Agility: 3
// Player 2:
// Strength: 3, Stamina: 4, Agility: 3
// Player 1 Skill: 120
// Player 2 Skill: 400
// Chance: 100 / ((Player 1 Skill + Player 2 Skill) / Player X Skill)
// Player 1 Chance: 23.01
// Player 2 Chance: 76.92

class CommenceBoxingMatch
{
	const NUMBER_OF_ROUNDS = 12;

	protected $boxingMatch = null;

	protected $originator = null;

	protected $challenger = null;

	protected $victor = null;

	protected $roundResults = null;

	protected $game = null;

	public function __construct(BoxingMatch $boxingMatch, User $challenger)
	{
		$this->boxingMatch = $boxingMatch;

		$this->originator = $this->boxingMatch->originator;

		$this->challenger = $challenger;

		$this->roundResults = collect();

		$this->fightWinner = null;

		$this->game = app(Game::class);
	}

	public function fight()
	{
		$this->originator->boxingSkill = $this->calculatePlayerSkill($this->originator);
		$this->challenger->boxingSkill = $this->calculatePlayerSkill($this->challenger);

		$playersSkillPercentage = $this->calculatePlayersSkillPercentage(
			$this->originator->boxingSkill, 
			$this->challenger->boxingSkill
		);

		list(
			$this->originator->boxingSkillPercentage,
			$this->challenger->boxingSkillPercentage
		) = $playersSkillPercentage;

		$fighters = collect([
			$this->originator,
			$this->challenger
		])
			->sortBy('boxingSkillPercentage', SORT_NUMERIC)
		;

		for($i = 1; $i <= self::NUMBER_OF_ROUNDS; ++$i) {

			// Players are at equal chance.
			if ($this->originator->boxingSkillPercentage
				 == $this->challenger->boxingSkillPercentage) {
				$roll = round($this->game->dice()->roll(1, 2));

				$winner = $this->originator;

				if ($roll == 2) {
					$winner = $this->challenger;
				}

				$this->roundResults->prepend($winner, $i);

				continue;
			}

			$roll = $this->game->dice()->roll(1, 100);

			if ($roll <= $fighters->first()->boxingSkillPercentage) {
				$this->roundResults->prepend($fighters->first(), $i);
				continue;
			}

			if ($roll <= $fighters->last()->boxingSkillPercentage) {
				$this->roundResults->prepend($fighters->last(), $i);
				continue;
			}

			$this->roundResults->prepend(null, $i);

		}

		$originatorRounds = $this->roundResults
			->where('id', $this->originator->getKey())
			->count()
		;

		$challengerRounds = $this->roundResults
			->where('id', $this->challenger->getKey())
			->count()
		;

		$this->fightWinner = $this->originator;

		if ($challengerRounds == $originatorRounds) {
			$this->fightWinner = null;
		}

		if ($challengerRounds > $originatorRounds) {
			$this->fightWinner = $this->challenger;
		}

		return $this;
	}

	public function wasADraw()
	{
		return is_null($this->fightWinner);
	}

	public function winner()
	{
		return $this->fightWinner;
	}

	public function rounds()
	{
		return $this->roundResults;
	}

	public function originator()
	{
		return $this->originator;
	}

	public function challenger()
	{
		return $this->challenger;
	}

	protected function calculatePlayerSkill(User $player)
	{
		$gymAttributes = [
			'stamina' => 1,
			'agility' => 1,
			'strength' => 1,
		];

		$gymAttributes['stamina'] += $player->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STAMINA_LEVEL};
		$gymAttributes['agility'] += $player->attribute->{PlayerAttribute::ATTRIBUTE_GYM_AGILITY_LEVEL};
		$gymAttributes['strength'] += $player->attribute->{PlayerAttribute::ATTRIBUTE_GYM_STRENGTH_LEVEL};

		$calc = ($gymAttributes['strength'] * ($gymAttributes['agility'] * 10)) * $gymAttributes['stamina'];

		return $calc;
	}

	protected function calculatePlayersSkillPercentage($originatorSkill, $challengerSkill)
	{
		return [
			($originatorSkill / ($originatorSkill + $challengerSkill)) * 100,
			($challengerSkill / ($originatorSkill + $challengerSkill)) * 100,
		];
	}

}