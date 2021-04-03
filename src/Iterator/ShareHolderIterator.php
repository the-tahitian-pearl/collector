<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Iterator;

use Countable;
use Iterator;
use TheTahitianPearl\Collector\Dto\ShareHolder;
use TheTahitianPearl\Collector\Util\CountUtil;


class ShareHolderIterator implements Iterator, Countable
{
    public function __construct(private array $shareHolders = [], private int $position = 0) {
    }

    final public function rewind(): void
    {
        $this->position = 0;
    }

    final public function first(): ShareHolder
    {
        return $this->shareHolders[0];
    }

    final public function current(): ShareHolder
    {
        return $this->shareHolders[$this->position];
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

    final public function add(ShareHolder $shareHolder): void
    {
        $this->shareHolders[] = $shareHolder;
    }

    final public function get(int $position): ShareHolder
    {
        return $this->shareHolders[$position];
    }

    final public function toArray(): array
    {
        return $this->shareHolders;
    }

    final public function count(): int
    {
        return CountUtil::hasTotalOf($this->shareHolders);
    }
}