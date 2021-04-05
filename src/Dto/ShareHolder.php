<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use TheTahitianPearl\Collector\Dto\Money\Coin;
use TheTahitianPearl\Collector\Dto\Money\CoinBag;

class ShareHolder
{
    private string $name;

    private int $shareRatio;

    private CoinBag $coinBag;

    private Coin|null $shareCoin = null;

    public function __construct(string $name, CoinBag $coinBag, int $shareRatio = 0)
    {
        $this->name = $name;
        $this->coinBag = $coinBag;
        $this->shareRatio = $shareRatio;

        $this->coinBag->addShareHolder($this);
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    final public function getShareRatio(): int
    {
        return $this->shareRatio;
    }

    final public function setShareRatio(int $shareRatio): self
    {
        $this->shareRatio = $shareRatio;

        return $this;
    }

    public function getCoinBag(): CoinBag
    {
        return $this->coinBag;
    }

    public function setCoinBag(CoinBag $coinBag): self
    {
        $this->coinBag = $coinBag;

        return $this;
    }

    final public function previewShare(): ?Coin
    {
        return $this->shareCoin;
    }

    final public function claimShare(): ?Coin
    {
        if ($this->shareCoin === null) {
            return $this->shareCoin;
        }

        return $this->shareCoin;
    }

}