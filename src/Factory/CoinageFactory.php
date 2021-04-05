<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Factory;

use TheTahitianPearl\Collector\Dto\Money\Coin;
use TheTahitianPearl\Collector\Dto\Money\CoinBag;


class CoinageFactory
{
    final public function splitIntoNewCoins(Coin $coin, int $amount): CoinBag
    {
        $splitResults = $coin->flipTails()->allocateTo($amount);
        $coins = new CoinBag();

        foreach ($splitResults as $result) {
            $newCoin = new Coin($coin->flipHeads()->getCode(), $result->getAmount());
            $coins->put($newCoin);
        }

        return $coins;
    }
}