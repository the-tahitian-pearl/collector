<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto\Countries;

use JetBrains\PhpStorm\Pure;
use TheTahitianPearl\Collector\Util\CountUtil;

class CoinCirculation
{
    public function __construct(private array $countries = []) {
    }

    final public function getCountries(): array    {
        return $this->countries;
    }

    final public function getByCountryCode(string $countryCode): Country
    {
        return $this->countries[$countryCode];
    }

    #[Pure]
    final public function count(): int
    {
        return CountUtil::hasTotalOf($this->countries);
    }
}