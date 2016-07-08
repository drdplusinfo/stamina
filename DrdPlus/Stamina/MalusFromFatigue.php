<?php
namespace DrdPlus\Stamina;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Tools\Calculations\SumAndRound;
use Granam\Tools\ValueDescriber;

/**
 * @method static MalusFromFatigue getEnum($malusValue)
 */
class MalusFromFatigue extends IntegerEnum
{
    /**
     * @param int $malusValue
     * @return MalusFromFatigue
     * @throws \DrdPlus\Stamina\Exceptions\UnexpectedMalusValue
     * @throws \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     */
    public static function getIt($malusValue)
    {
        return static::getEnum($malusValue);
    }

    const MOST = -3;

    /**
     * @param mixed $enumValue
     * @return int
     * @throws \DrdPlus\Stamina\Exceptions\UnexpectedMalusValue
     * @throws \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     */
    protected static function convertToEnumFinalValue($enumValue)
    {
        $finalValue = parent::convertToEnumFinalValue($enumValue);
        if ($finalValue > 0 // note: comparing negative numbers
            || $finalValue < self::MOST
        ) {
            throw new Exceptions\UnexpectedMalusValue(
                'Malus can be between 0 and ' . self::MOST . ', got ' . ValueDescriber::describe($enumValue)
            );
        }

        return $finalValue;
    }

    /**
     * @param PropertyBasedActivity $activity
     * @return int
     */
    public function getValueForActivity(PropertyBasedActivity $activity)
    {
        if ($activity->usesStrength() || $activity->usesAgility() || $activity->usesKnack()) {
            return $this->getValue();
        }

        return SumAndRound::half($this->getValue());
    }

}