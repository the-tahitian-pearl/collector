<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test\Dto\Money;

use PHPUnit\Framework\TestCase;
use TheTahitianPearl\Collector\Dto\Money\Coin;
use TheTahitianPearl\Collector\Dto\Money\CoinBag;
use TheTahitianPearl\Collector\Test\CoinProviderTrait;

/**
 * @group dto
 */
final class CoinBagTest extends TestCase
{
    use CoinProviderTrait;

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function get_first_coin_from_bag(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertEquals(
            $coinOne->flipTails()->getAmount(),
            $coinBag->first()->flipTails()->getAmount(),
        );
    }

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function get_last_coin_from_bag(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertEquals(
            $cointThree->flipTails()->getAmount(),
            $coinBag->last()->flipTails()->getAmount(),
        );
    }

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function get_highest_value_coin_from_bag(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertEquals(
            $cointThree->flipTails()->getAmount(),
            $coinBag->getHighestValue()->flipTails()->getAmount(),
        );
    }

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function get_lowest_value_coin_from_bag(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertEquals(
            $coinOne->flipTails()->getAmount(),
            $coinBag->getLowestValue()->flipTails()->getAmount(),
        );
    }

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function count_total_coins(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertEquals(
            3,
            $coinBag->count(),
        );

        $newCoin = new Coin('EUR', 1000);
        $coinBag->put($newCoin);

        self::assertEquals(
            4,
            $coinBag->count(),
        );

        $coinBag->remove(2);
        $coinBag->remove(3);

        self::assertEquals(
            2,
            $coinBag->count(),
        );
    }

    /**
     * @test
     * @dataProvider coinsDifferentCurrencyProvider
     */
    public function get_currencies_from_coin_bag(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        $currencyList = $coinBag->getCurrencies();

        self::assertTrue(
            $currencyList->contains($coinBag->first()->flipHeads())
        );

        self::assertTrue(
            $currencyList->contains($coinBag->get(1)->flipHeads())
        );

        self::assertTrue(
            $currencyList->contains($coinBag->get(2)->flipHeads())
        );
    }

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function coin_bag_contains_same_currency(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);


        self::assertTrue(
            $coinBag->containsSameCurrency()
        );
    }

    /**
     * @test
     * @dataProvider coinsDifferentCurrencyProvider
     */
    public function coin_bag_contains_different_currency(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {
        $coinBag = new CoinBag([
            $coinOne,
            $coinTwo,
            $cointThree
        ]);

        self::assertFalse(
           $coinBag->containsSameCurrency()
        );
    }
}