<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Service;

use LogicException;
use Money\Money;
use PHP_IBAN\IBAN;
use TheTahitianPearl\Collector\Dto\Collector;

class BankAccountService implements WealthInterface
{
    public const APPEND = 'append';
    public const SUBTRACT = 'subtract';

    final public function getTotalAmount(): int
    {
        // TODO: Implement getTotalAmount() method.
    }
    final public function multiCalculation(string $method, Money $swagger, Collector $treasureChest): Money
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

    final public function hasSameValutaMoneyBags(Collector $treasureChest): bool
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

    final public function getObfuscatedBankAccounts(Collector $treasureChest): array
    {
        if (count($treasureChest->getBankAccounts()) === 0) {
            throw  new LogicException('No bank accounts given to obfuscate.');
        }

        return array_map(
            static function (IBAN $iban) {
                return iban_to_obfuscated_format($iban);
            }, $treasureChest->getBankAccounts());
    }

    final public function getBankAccountsCountries(Collector $treasureChest): array
    {
        if (count($treasureChest->getBankAccounts()) === 0) {
            throw  new LogicException('No bank accounts given to obfuscate.');
        }

        return array_map(
            static function (IBAN $iban) {
                return $iban->Country($iban);
        }, $treasureChest->getBankAccounts());
    }


}