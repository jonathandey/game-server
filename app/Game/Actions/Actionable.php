<?php

namespace App\Game\Actions;

use App\Game\Player;

interface Actionable
{
	public function name();

	public function difficulty(float $difficulty = null);
	
	public function attempt();

	public function rewards();

	public function punishments();
}