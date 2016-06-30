<?php
namespace DrdPlus\Tests\Stamina;

use DrdPlus\Stamina\ReasonToRollAgainstFatigueMalus;

class ReasonToRollAgainstFatigueMalusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_fatigue_reason()
    {
        $fatigueReason = ReasonToRollAgainstFatigueMalus::getFatigueReason();
        self::assertInstanceOf(ReasonToRollAgainstFatigueMalus::class, $fatigueReason);
        self::assertTrue($fatigueReason->becauseOfFatigue());
        self::assertFalse($fatigueReason->becauseOfRest());
        self::assertSame('fatigue', $fatigueReason->getValue());
        self::assertSame('fatigue', ReasonToRollAgainstFatigueMalus::FATIGUE);
        self::assertSame(ReasonToRollAgainstFatigueMalus::getIt('fatigue'), $fatigueReason);
    }

    public function I_can_use_rest_reason()
    {
        $restReason = ReasonToRollAgainstFatigueMalus::getRestReason();
        self::assertInstanceOf(ReasonToRollAgainstFatigueMalus::class, $restReason);
        self::assertTrue($restReason->becauseOfRest());
        self::assertFalse($restReason->becauseOfFatigue());
        self::assertSame('rest', $restReason->getValue());
        self::assertSame('rest', ReasonToRollAgainstFatigueMalus::REST);
        self::assertSame(ReasonToRollAgainstFatigueMalus::getIt('rest'), $restReason);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Stamina\Exceptions\UnknownReasonToRollAgainstMalus
     * @expectedExceptionMessageRegExp ~bored~
     */
    public function I_can_not_create_unknown_reason()
    {
        ReasonToRollAgainstFatigueMalus::getEnum('bored');
    }
}
