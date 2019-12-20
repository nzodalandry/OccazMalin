<?php
namespace App\Enum;

use App\Interfaces\EnumInterface;

abstract class AdsStateEnum implements EnumInterface
{
    /**
     * Enum Keys
     */
    const STATE_NEW     = "new";
    const STATE_USED    = "used";
    const STATE_BROKEN  = "broken";

    /**
     * Enum values
     */
    private static $enum = [
        self::STATE_NEW     => "New",
        self::STATE_USED    => "Used",
        self::STATE_BROKEN  => "Broken",
    ];

    /**
     * Get one of enum
     *
     * @param string $item
     * @return sting
     */
    public static function get($item): string
    {
        if (!isset(static::$enum[$item])) {
            return "Unknown type ($item)";
        }

        return static::$enum[$item];
    }

    /**
     * Get list of enum
     *
     * @return array
     */
    public static function getAll(bool $flip=false): array
    {
        return $flip ? array_flip(self::$enum) : self::$enum;
    }
}