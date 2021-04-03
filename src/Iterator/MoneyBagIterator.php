<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Iterator;

use Iterator;
use Money\Money;
use TheTahitianPearl\Collector\Util\CountUtil;


class MoneyBagIterator implements Iterator
{
    public function __construct(private array $moneyArray = [], private int $position = 0) {
    }

    final public function rewind(): void
    {
        $this->position = 0;
    }

    final public function first(): Money
    {
        return $this->moneyArray[0];
    }

    final public function current(): Money
    {
        return $this->moneyArray[$this->position];
    }

    final public function key(): int
    {
        return $this->position;
    }

    final public function next(): void
    {
        ++$this->position;
    }

    final public function valid(): bool
    {
        return isset($this->moneyArray[$this->position]);
    }

    final public function validPosition(int $position): bool
    {
        return isset($this->moneyArray[$position]);
    }

    final public function add(Money $money): void
    {
        $this->moneyArray[] = $money;
    }

    final public function get(int $position): Money
    {
        return $this->moneyArray[$position];
    }

    final public function toArray(): array
    {
        return $this->moneyArray;
    }

    final public function count(): int
    {
        return CountUtil::hasTotalOf($this->moneyArray);
    }
}