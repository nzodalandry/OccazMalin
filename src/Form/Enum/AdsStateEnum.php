<?php
namespace App\Form\Enum;

abstract class AdsStateEnum
{
    const STATE_NEW     = "new";
    const STATE_USED    = "used";
    const STATE_BROKEN  = "broken";

    protected static $stateName = [
        self::STATE_NEW     => "New",
        self::STATE_USED    => "Used",
        self::STATE_BROKEN  => "Broken",
    ];

    public static function getStateName($stateShortName)
    {
        if (!isset(static::$stateName[$stateShortName])) {
            return "Unknown state ($stateShortName)";
        }

        return static::$stateName[$stateShortName];
    }

    public static function getAvailableStates()
    {
        return self::$stateName;
    }
}