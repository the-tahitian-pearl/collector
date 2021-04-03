<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use JetBrains\PhpStorm\Pure;
use Money\Money;
use RuntimeException;

class TreasureChest
{
    /**
     * @var Money[]
     */
    private array $moneybags = [];

    #[Pure]
    final public function isFilled(): bool
    {
        return count($this->moneybags) > 0;
    }

    final public function getTotalValue(): Money
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @param Money[] $moneyBags
     */
    final public function setMoneyBags(array $moneyBags): self
    {
        $this->moneybags = $moneyBags;

        return $this;
    }

    /**
     * @return Money[]
     */
    final public function getMoneyBags(): array
    {
        return $this->moneybags;
    }

    final public function getCertainMoneyBag(int $number): Money
    {
        if (empty($this->moneybags)) {
            throw new RuntimeException('Has no money bags');
        }

        return $this->moneybags[$number];
    }
}