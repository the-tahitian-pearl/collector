<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto\Money;

class CompareResults
{
    private int $amount;

    private bool $hasSameCurrency;

    private bool $hasEqualAmount;

    private bool $hasGreaterAmount;

    private CoinBag $comparedMoneyBag;

    private CoinBag $originalMoneyBag;

    public function __construct(CoinBag $moneyBag, CoinBag $comparedMoneyBag)
    {
        $this
            ->setOriginalMoneyBag($moneyBag)
            ->setComparedMoneyBag($comparedMoneyBag)
            ->setAmount(
                $moneyBag->getValue()->compare($comparedMoneyBag->getValue())
            )
            ->setHasSameCurrency(
                $moneyBag->getValue()->isSameCurrency($comparedMoneyBag->getValue())
            )
            ->setHasEqualAmount(
                $moneyBag->getValue()->equals($comparedMoneyBag->getValue())
            )
            ->setHasGreaterAmount(
                $moneyBag->getValue()->greaterThan($comparedMoneyBag->getValue())
            );
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    private function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function isHasSameCurrency(): bool
    {
        return $this->hasSameCurrency;
    }

    private function setHasSameCurrency(bool $hasSameCurrency): self
    {
        $this->hasSameCurrency = $hasSameCurrency;

        return $this;
    }

    public function isHasEqualAmount(): bool
    {
        return $this->hasEqualAmount;
    }

    private function setHasEqualAmount(bool $hasEqualAmount): self
    {
        $this->hasEqualAmount = $hasEqualAmount;

        return $this;
    }

    public function hasGreaterAmount(): bool
    {
        return $this->hasGreaterAmount;
    }

    private function setHasGreaterAmount(bool $hasGreaterAmount): self
    {
        $this->hasGreaterAmount = $hasGreaterAmount;

        return $this;
    }


    public function getComparedMoneyBag(): CoinBag
    {
        return $this->comparedMoneyBag;
    }

    private function setComparedMoneyBag(CoinBag $comparedMoneyBag): self
    {
        $this->comparedMoneyBag = $comparedMoneyBag;

        return $this;
    }

    public function getOriginalMoneyBag(): CoinBag
    {
        return $this->originalMoneyBag;
    }

    private function setOriginalMoneyBag(CoinBag $originalMoneyBag): self
    {
        $this->originalMoneyBag = $originalMoneyBag;

        return $this;
    }
}