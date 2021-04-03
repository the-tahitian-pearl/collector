<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Service;

use LogicException;
use Money\Money;
use TheTahitianPearl\Collector\Dto\Collector;
use TheTahitianPearl\Collector\Iterator\MoneyBagIterator;

class MoneyBagService
{
    public static function multiCalculation(string $method, Money $money, MoneyBagIterator $moneyBagIterator): Money
    {
        foreach ($moneyBagIterator as $moneyBag) {
            $money = match ($method) {
                Collector::APPEND => $money->add($moneyBag),
                Collector::SUBTRACT => $money->subtract($moneyBag),
                default => throw new LogicException(
                    sprintf('[method=%s] is not a valid method', $method)
                )
            };
        }

        return $money;
    }

    public static function hasSameCurrencyMoneyBags(MoneyBagIterator $moneyBagIterator): bool
    {
        foreach ($moneyBagIterator as $money) {
            if ($moneyBagIterator
                    ->first()
                    ->getCurrency()
                    ->getCode() !== $money->getCurrency()->getCode()) {
                return false;
            }
        }

        return true;
    }

    public static function getHighestValue(MoneyBagIterator $moneyBagIterator): Money
    {
        $highestValue = $moneyBagIterator->first();
        foreach ($moneyBagIterator as  $money) {
            if ($moneyBagIterator->key() === 0) {
                continue;
            }

            if ($highestValue->greaterThanOrEqual($money)) {
                continue;
            }

            $highestValue = $money;
        }

       return $highestValue;
    }
}