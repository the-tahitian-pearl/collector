<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto\Money;

use Countable;
use Exception;
use Iterator;
use JetBrains\PhpStorm\Pure;
use Money\Currencies\CurrencyList;
use TheTahitianPearl\Collector\Dto\ShareHolder;
use TheTahitianPearl\Collector\Util\CountUtil;

class CoinBag implements Iterator, Countable
{
    private const MINOR_UNIT_PAIRS = 2;

    private CurrencyList $currencies;

    public function __construct(
        private array $coinBag = [],
        private array $shareHolders = [],
        private int $position = 0,
    ) {
        $this->setCurrenciesListAndDefineCoinBags();
    }

    final public function put(Coin $coin): void
    {
        $this->coinBag[] = $coin;
    }

    final public function remove(int $position): void
    {
        unset($this->coinBag[$position]);
    }

    #[Pure]
    final public function count(): int
    {
        return CountUtil::hasTotalOf($this->coinBag);
    }

    final public function current(): Coin
    {
        return $this->coinBag[$this->position];
    }

    #[Pure]
    final public function first(): Coin
    {
        $firstKey = array_key_first($this->coinBag);

        return $this->coinBag[$firstKey];
    }

    final public function last(): Coin
    {
        $lastKey = array_key_last($this->coinBag);

        return $this->coinBag[$lastKey];
    }

    final public function get(int $position): Coin
    {
        return $this->coinBag[$position];
    }

    final public function getHighestValue(): ?Coin
    {
        if (CountUtil::hasNone($this->coinBag)) {
            return null;
        }

        if (CountUtil::hasOne($this->coinBag)) {
            return $this->first();
        }

        $highestValue = $this->first()->flipTails()->getAmount();
        $highestValueCoin = $this->first();

        foreach ($this->coinBag as $coin) {
            assert($coin instanceof Coin);

            if ((int)$coin->flipTails()->getAmount() <= $highestValue) {
                continue;
            }

            $highestValue = $coin->flipTails()->getAmount();
            $highestValueCoin = $coin;
        }

        return $highestValueCoin;
    }

    final public function getLowestValue(): ?Coin
    {
        if (CountUtil::hasNone($this->coinBag)) {
            return null;
        }

        if (CountUtil::hasOne($this->coinBag)) {
            return $this->first();
        }

        $lowestValue = $this->first()->flipTails()->getAmount();
        $lowestValueCoin = $this->first();

        foreach ($this->coinBag as $coin) {
            assert($coin instanceof Coin);
            if ((int)$coin->flipTails()->getAmount() >= $lowestValue) {
                continue;
            }

            $lowestValue = $coin->flipTails()->getAmount();
            $lowestValueCoin = $coin;
        }

        return $lowestValueCoin;
    }

    final public function key(): int
    {
        return $this->position;
    }

    final public function next(): void
    {
        ++$this->position;
    }

    final public function rewind(): void
    {
        $this->position = 0;
    }

    final public function valid(): bool
    {
        return empty($this->coinBag[$this->position]);
    }

    final public function validPosition(int $position): bool
    {
        return empty($this->coinBag[$position]);
    }

    final public function toArray(): array
    {
        return $this->coinBag;
    }

    final public function getCurrencies(): CurrencyList
    {
        return $this->currencies;
    }

    final public function containsSameCurrency(): bool
    {
        $mainCurrency = $this->first()->flipHeads()->getCode();

        try {
            $foundCurrencies = array_filter(
                $this->currencies->getIterator()->getArrayCopy(),
                static function (string $currency) use ($mainCurrency) {
                    return $currency !== $mainCurrency;
                }
            );
        } catch (Exception $e) {
            throw new $e;
        }

        return CountUtil::hasNone($foundCurrencies);
    }

    private function setCurrenciesListAndDefineCoinBags(): void
    {
        if (CountUtil::hasNone($this->coinBag)) {
            return;
        }

        $currencies = [];
        foreach ($this->coinBag as $coin) {
            assert($coin instanceof Coin);
            $coin->setCoinBag($this);
            $currencies[$coin->flipHeads()->getCode()] = self::MINOR_UNIT_PAIRS;
        }

        $this->currencies = new CurrencyList($currencies);
    }

    /**
     * @return ShareHolder[]
     */
    final public function getShareHolders(): array
    {
        return $this->shareHolders;
    }

    final public function addShareHolder(ShareHolder $shareHolder): self
    {
        $this->shareHolders[] = $shareHolder;

        return $this;
    }
}