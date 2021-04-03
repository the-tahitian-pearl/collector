<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Iterator;

use Countable;
use Iterator;
use PHP_IBAN\IBAN;
use TheTahitianPearl\Collector\Util\CountUtil;

class BankAccountIterator implements Iterator, Countable
{
    public function __construct(private array $bankAccountArray = [], private int $position = 0) {
    }

    final public function rewind(): void
    {
        $this->position = 0;
    }

    final public function current(): IBAN
    {
        return $this->bankAccountArray[$this->position];
    }

    final public function key(): int
    {
        return $this->position;
    }

    final public function next(): void
    {
        ++$this->position;
    }

    final public function add(IBAN $bankAccount): void
    {
        $this->bankAccountArray[] = $bankAccount;
    }

    final public function valid(): bool
    {
        return isset($this->bankAccountArray[$this->position]);
    }

    final public function toArray(): array
    {
        return $this->bankAccountArray;
    }

    final public function count(): int
    {
        return CountUtil::hasTotalOf($this->bankAccountArray);
    }

    final public function clear(): void
    {
        $this->bankAccountArray = [];
    }
}