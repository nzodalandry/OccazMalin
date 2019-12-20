<?php
namespace App\Enum;

use App\Interfaces\EnumInterface;

abstract class MediasTypesEnum implements EnumInterface
{
    /**
     * Enum Keys
     */
    const TYPE_APPLICATION  = "application";
    const TYPE_AUDIO        = "audio";
    const TYPE_CHEMICAL     = "chemical";
    const TYPE_IMAGE        = "image";
    const TYPE_MESSAGE      = "message";
    const TYPE_MODEL        = "model";
    const TYPE_TEXT         = "text";
    const TYPE_VIDEO        = "video";
    const TYPE_UNKNOW       = "unknow";

    /**
     * Enum values
     */
    private static $enum = [
        self::TYPE_APPLICATION  => "Application",
        self::TYPE_AUDIO        => "Audio",
        self::TYPE_CHEMICAL     => "Chemical",
        self::TYPE_IMAGE        => "Image",
        self::TYPE_MESSAGE      => "Message",
        self::TYPE_MODEL        => "Model",
        self::TYPE_TEXT         => "Text",
        self::TYPE_VIDEO        => "Video",
        self::TYPE_UNKNOW       => "Unknow",
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