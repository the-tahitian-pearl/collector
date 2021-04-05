<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Util;

use ArrayIterator;
use Countable;
use JetBrains\PhpStorm\Pure;
use LogicException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Traversable;

class CurrencyUtil
{
    final public static function createCurrencyObject(string $currency): Currency
    {
        $newCurrency = new Currency($currency);
        self::validateCurrency($newCurrency);

        return $newCurrency;
    }

    #[Pure]
    final public static function getIsoCurrencies(): ISOCurrencies
    {
        return new ISOCurrencies();
    }

    final public static function getIsoCurrenciesIterator(): ArrayIterator|Traversable
    {
        return (new ISOCurrencies())->getIterator();
    }

    final public static function validateCurrency(Currency $currency): void
    {
        $currencies = self::getIsoCurrencies();
        if (!$currencies->contains($currency)) {
            throw new LogicException(
             'Cannot create coin of currency %s'
            );
        }
    }
}