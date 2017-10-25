<?php

namespace App;

use App\Game\Actions\Gym\Gym;
use Illuminate\Database\Eloquent\Model;
use App\Game\Outcomes\Gym\StaminaSkillIncrement;
use App\Game\Outcomes\Gym\AgilitySkillIncrement;
use App\Game\Outcomes\Gym\StrengthSkillIncrement;

class PlayerAttribute extends Model
{
    //
	public $timestamps = false;
    
    const ATTRIBUTE_CRIME_SKILL = 'crime_skill';

    const ATTRIBUTE_GYM_STRENGTH_PROGRESS = 'gym_strength_progress';

    const ATTRIBUTE_GYM_STRENGTH_LEVEL = 'gym_strength_level';

    const ATTRIBUTE_GYM_STAMINA_PROGRESS = 'gym_stamina_progress';

    const ATTRIBUTE_GYM_STAMINA_LEVEL = 'gym_stamina_level';

    const ATTRIBUTE_GYM_AGILITY_PROGRESS = 'gym_agility_progress';

    const ATTRIBUTE_GYM_AGILITY_LEVEL = 'gym_agility_level';

    public function incrementCrimeSkill($value)
    {
    	$this->increment(self::ATTRIBUTE_CRIME_SKILL, $value);
    }

    public function incrementGymSkill($reward)
    {
    	$value = $reward->value();

		if ($reward instanceof StrengthSkillIncrement) {
			$this->incrementGymStrength(
				$value
			);
		}

		if ($reward instanceof StaminaSkillIncrement) {
			$this->incrementGymStamina(
				$value
			);
		}

		if ($reward instanceof AgilitySkillIncrement) {
			$this->incrementGymAgility(
				$value
			);
		}
    }

    public function incrementGymStrength($value)
    {
        $this->updateGymProgressionLevels(
            $value, 
            $this->strengthTarget(),
            self::ATTRIBUTE_GYM_STRENGTH_PROGRESS,
            self::ATTRIBUTE_GYM_STRENGTH_LEVEL
        );
    }

    public function incrementGymStamina($value)
    {
        $this->updateGymProgressionLevels(
            $value, 
            $this->staminaTarget(),
            self::ATTRIBUTE_GYM_STAMINA_PROGRESS,
            self::ATTRIBUTE_GYM_STAMINA_LEVEL
        );
    }

    public function incrementGymAgility($value)
    {
    	$this->updateGymProgressionLevels(
            $value, 
            $this->agilityTarget(),
            self::ATTRIBUTE_GYM_AGILITY_PROGRESS,
            self::ATTRIBUTE_GYM_AGILITY_LEVEL
        );
    }

    public function strengthTarget()
    {
        return ($this->{self::ATTRIBUTE_GYM_STRENGTH_LEVEL} + 1) * Gym::LEVEL_INCREMENT;
    }

    public function staminaTarget()
    {
        return ($this->{self::ATTRIBUTE_GYM_STAMINA_LEVEL} + 1) * Gym::LEVEL_INCREMENT;
    }

    public function agilityTarget()
    {
        return ($this->{self::ATTRIBUTE_GYM_AGILITY_LEVEL} + 1) * Gym::LEVEL_INCREMENT;
    }

    protected function updateGymProgressionLevels($incrementValue, $targettedTotal, $progressField, $levelField)
    {
        $newTotalProgress = $this->{$progressField} + $incrementValue;

        if ($newTotalProgress >= $targettedTotal) {
            $progressionDifference = $newTotalProgress - $targettedTotal;

            $this->{$progressField} = $progressionDifference;
            $this->{$levelField} += 1;

            $this->save();

        } else {
            $this->increment($progressField, $incrementValue);
        }        
    }
}
