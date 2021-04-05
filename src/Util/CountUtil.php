<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Util;

use Countable;
use JetBrains\PhpStorm\Pure;

class CountUtil
{
    #[Pure]
    final public static function hasTotalOf(array|Countable $countable): int
    {
        return count($countable);
    }

    #[Pure]
    final public static function hasOneOrMore(array|Countable $countable): bool
    {
        return count($countable) >= 1;
    }

    #[Pure]
    final public static function hasOne(array|Countable $countable): bool
    {
        return count($countable) === 1;
    }

    #[Pure]
    final public static function hasNone(array|Countable $countable): bool
    {
        return count($countable) === 0;
    }
}