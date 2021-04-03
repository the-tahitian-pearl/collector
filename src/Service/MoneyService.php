<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Service;

use LogicException;
use Money\Money;
use TheTahitianPearl\Collector\Dto\TreasureChest;

class MoneyService
{
    public const APPEND = 'append';
    public const SUBTRACT = 'subtract';

    final public function multiCalculation(string $method, Money $swagger, TreasureChest $treasureChest): Money
    {
        foreach ($treasureChest->getMoneyBags() as $moneyBag) {
            $swagger = match ($method) {
                self::APPEND => $swagger->add($moneyBag),
                self::SUBTRACT => $swagger->subtract($moneyBag),
                default => throw new LogicException(
                    sprintf('[method=%s] is not a valid method', $method)
                )
            };
        }

        return $swagger;
    }

    final public function hasSameValutaMoneyBags(TreasureChest $treasureChest): bool
    {
        $firstMoneyBag = $treasureChest->getCertainMoneyBag(0);

        foreach ($treasureChest->getMoneyBags() as $number => $moneyBag) {
            if ($number === array_key_first($treasureChest->getMoneyBags())) {
                continue;
            }

            if ($firstMoneyBag->getCurrency()->getCode() !== $moneyBag->getCurrency()->getCode()) {
                return false;
            }
        }

        return true;
    }
}