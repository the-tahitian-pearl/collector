<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use LogicException;
use Money\Money;
use TheTahitianPearl\Collector\Iterator\MoneyBagIterator;
use TheTahitianPearl\Collector\Util\CountUtil;

class ShareHolder
{
    private string $name;

    private int $shareAmount = -1;

    private int $moneyBagPosition = -1;

    private Money $share;

    final public function getName(): string
    {
        return $this->name;
    }

    final public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    final public function getMoneyBagPosition(): int
    {
        return $this->moneyBagPosition;
    }

    final public function hasMoneyBagPosition(): bool
    {
        return $this->moneyBagPosition !== -1;
    }

    final public function setMoneyBagPosition(int $moneyBagPosition): self
    {
        $this->moneyBagPosition = $moneyBagPosition;

        return $this;
    }

    final public function getShareAmount(): int
    {
        return $this->shareAmount;
    }

    final public function setShareAmount(int $shareAmount,): self
    {
        $this->shareAmount = $shareAmount;

        return $this;
    }

    public function claimShare(): Money
    {
        return $this->share;
    }

    public function setShare(MoneyBagIterator $moneyBagIterator): ShareHolder
    {

        if ($this->getShareAmount() > 100 || $this->getShareAmount() <= 0) {
            throw new LogicException(
                'Share amount for stakeholder cannot be over 100 or below/even as 0'
            );
        }

        if (CountUtil::hasNone($moneyBagIterator->toArray())) {
            throw new LogicException(
                'No money bags available for shareholder'
            );
        }

        if (!$this->hasMoneyBagPosition()) {
            throw new LogicException(
                'Money bag position has not been set for current shareholder'
            );
        }

        if (!$moneyBagIterator->validPosition($this->getMoneyBagPosition())) {
            throw new LogicException(
                'Money bag does not exists in the iterator'
            );
        }

        $moneyBag = $moneyBagIterator->get($this->getMoneyBagPosition());
        $this->share = $moneyBag->allocate([(string)$this->getShareAmount()])[0];

        return $this;
    }
}