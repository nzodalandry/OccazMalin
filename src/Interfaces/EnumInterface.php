<?php
namespace App\Interfaces;

interface EnumInterface
{
    /**
     * Get on of enum
     *
     * @param string $item
     * @return sting
     */
    public static function get(string $item): string;

    /**
     * Get list of enum
     *
     * @return array
     */
    public static function getAll(bool $flip=false): array;
}