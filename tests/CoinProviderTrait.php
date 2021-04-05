<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test;


use TheTahitianPearl\Collector\Dto\Money\Coin;

trait CoinProviderTrait
{
    public function coinsSameCurrencyProvider(): array
    {
        return [
            [new Coin('EUR', 1000), new Coin('EUR', 1500), new Coin('EUR', 3000)],
        ];
    }

    public function coinsDifferentCurrencyProvider(): array
    {
        return [
            [new Coin('EUR', 1000), new Coin('XCD', 1500), new Coin('USD', 3000)],
        ];
    }
}