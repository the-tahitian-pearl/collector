<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Iterator;

use FilterIterator;
use Money\Money;

class ValueFilter extends FilterIterator
{
    public function __construct(MoneyBagIterator $iterator)
    {
        parent::__construct($iterator);
    }

    final public function accept(): bool
    {
        /** @var Money $first */
        $first = $this->getInnerIterator()->first();

        if ($first->greaterThanOrEqual($this->getInnerIterator()->current())) {
            return false;
        }

        return true;
    }
}