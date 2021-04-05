<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto\Countries;

use Money\Currency;

class Country
{
    private string $name;

    private string $officialName;

    private string $nativeName;

    private string $nativeOfficialName;

    private string $isoAlpha2;

    private string $isoAlpha3;

    private Currency $currency;

    private string $emoji;

    final public function getName(): string
    {
        return $this->name;
    }

    final public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    final public function getOfficialName(): string
    {
        return $this->officialName;
    }

    final public function setOfficialName(string $officialName): Country
    {
        $this->officialName = $officialName;

        return $this;
    }

    final public function getNativeName(): string
    {
        return $this->nativeName;
    }

    final public function setNativeName(string $nativeName): Country
    {
        $this->nativeName = $nativeName;

        return $this;
    }

    final public function getNativeOfficialName(): string
    {
        return $this->nativeOfficialName;
    }

    final public function setNativeOfficialName(string $nativeOfficialName): Country
    {
        $this->nativeOfficialName = $nativeOfficialName;

        return $this;
    }

    final public function getIsoAlpha2(): string
    {
        return $this->isoAlpha2;
    }

    final public function setIsoAlpha2(string $isoAlpha2): Country
    {
        $this->isoAlpha2 = $isoAlpha2;

        return $this;
    }

    final public function getIsoAlpha3(): string
    {
        return $this->isoAlpha3;
    }

    final public function setIsoAlpha3(string $isoAlpha3): Country
    {
        $this->isoAlpha3 = $isoAlpha3;

        return $this;
    }

    final public function getCurrency(): Currency
    {
        return $this->currency;
    }

    final public function setCurrency(Currency $currency): Country
    {
        $this->currency = $currency;

        return $this;
    }

    final public function getEmoji(): string
    {
        return $this->emoji;
    }

    final public function setEmoji(string $emoji): Country
    {
        $this->emoji = $emoji;

        return $this;
    }
}