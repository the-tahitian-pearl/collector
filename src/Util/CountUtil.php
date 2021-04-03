<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Util;


class CountUtil
{
    final public static function hasTotalOf(array $array): int
    {
        return count($array);
    }

    final public static function hasOneOrMore(array $array): bool
    {
        return count($array) >= 1;
    }

    final public static function hasNone(array $array): bool
    {
        return count($array) === 0;
    }
}