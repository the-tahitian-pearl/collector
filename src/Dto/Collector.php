<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use LogicException;
use Money\Money;
use RuntimeException;
use TheTahitianPearl\Collector\Iterator\BankAccountIterator;
use TheTahitianPearl\Collector\Iterator\MoneyBagIterator;
use TheTahitianPearl\Collector\Iterator\ShareHolderIterator;
use TheTahitianPearl\Collector\Service\MoneyBagService;
use TheTahitianPearl\Collector\Util\CountUtil;

class Collector
{
    public const APPEND = 'append';
    public const SUBTRACT = 'subtract';

    private ShareHolderIterator $shareHolders;

    private MoneyBagIterator $moneybagIterator;

    private BankAccountIterator $bankAccountIterator;

    public function getShareHolders(): ShareHolderIterator
    {
        return $this->shareHolders;
    }

    public function setShareHolders(ShareHolderIterator $shareHolders): self
    {
        $this->shareHolders = $shareHolders;

        return $this;
    }

    final public function isFilled(): bool
    {
        return !(
            CountUtil::hasNone($this->moneybagIterator->toArray()) &&
            CountUtil::hasNone($this->bankAccountIterator->toArray())
        );
    }

    final public function isEmpty(): bool
    {
        return (
            CountUtil::hasNone($this->moneybagIterator->toArray()) &&
            CountUtil::hasNone($this->bankAccountIterator->toArray())
        );
    }

    final public function hasBankAccounts(): bool
    {
        return CountUtil::hasOneOrMore(
            $this->bankAccountIterator->toArray()
        );
    }

    final public function getTotalMoneyBags(): int
    {
        return $this->moneybagIterator->count();
    }

    final public function getTotalBankAccounts(): int
    {
        return $this->bankAccountIterator->count();
    }

    final public function getTotalObjects(): int
    {
        return $this->getTotalMoneyBags() + $this->getTotalBankAccounts();
    }

    final public function setMoneyBagIterator(MoneyBagIterator $moneyBagIterator): self
    {
        $this->moneybagIterator = $moneyBagIterator;
        return $this;
    }

    final public function getMoneyBagIterator(): MoneyBagIterator
    {
        return $this->moneybagIterator;
    }

    final public function hasMoneyBags(): bool
    {
        return CountUtil::hasOneOrMore(
            $this->moneybagIterator->toArray()
        );
    }

    final public function getCertainMoneyBag(int $position): Money
    {
        if (CountUtil::hasNone($this->moneybagIterator->toArray())) {
            throw new RuntimeException('Has no money objects');
        }

        if (!$this->moneybagIterator->validPosition($position)) {
            throw new RuntimeException('Money object is not found in the money bag');
        }

        return $this->moneybagIterator->get($position);
    }

    final public function getTotalMoneyBagsValue(): Money
    {
        // TODO extend with other value objects in the future.
        return MoneyBagService::multiCalculation(
            self::APPEND,
            Money::EUR(0),
            $this->getMoneyBagIterator()
        );
    }

    final public function getHighestMoneyObjectFromMoneyBag(): Money
    {
        if (!MoneyBagService::hasSameCurrencyMoneyBags($this->getMoneyBagIterator())) {
            throw new LogicException(
                'Unable to get highest value because diverse of currencies'
            );
        }

        return MoneyBagService::getHighestValue($this->moneybagIterator);
    }

    final public function getHighestMoneyAmountFromMoneyBag(): string
    {
        if (!MoneyBagService::hasSameCurrencyMoneyBags($this->getMoneyBagIterator())) {
            throw new LogicException(
                'Unable to get highest value because diverse of currencies'
            );
        }

        return MoneyBagService::getHighestValue($this->moneybagIterator)->getAmount();
    }

    final public function getBankAccountIterator(): BankAccountIterator
    {
        return $this->bankAccountIterator;
    }

    final public function setBankAccountsIterator(BankAccountIterator $bankAccountIterator): self
    {
        $this->bankAccountIterator = $bankAccountIterator;

        return $this;
    }
}