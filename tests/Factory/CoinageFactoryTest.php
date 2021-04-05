<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test\Factory;

use PHPUnit\Framework\TestCase;
use TheTahitianPearl\Collector\Dto\Money\Coin;
use TheTahitianPearl\Collector\Dto\Money\CoinBag;
use TheTahitianPearl\Collector\Factory\CoinageFactory;
use TheTahitianPearl\Collector\Test\CoinProviderTrait;
use TheTahitianPearl\Collector\Util\CountUtil;

/**
 * @group factory
 */
final class CoinageFactoryTest extends TestCase
{
    use CoinProviderTrait;

    /**
     * @test
     * @dataProvider coinsSameCurrencyProvider
     */
    public function split_coin_into_new_coins(Coin $coinOne, Coin $coinTwo, Coin $cointThree): void
    {

        $coinage = new CoinageFactory();

        $coinBag = $coinage->splitIntoNewCoins($coinOne, 2);

        self::assertEquals(
            2,
            CountUtil::hasTotalOf($coinBag),
        );

        self::assertEquals(
            500,
            $coinBag->first()->flipTails()->getAmount(),
        );

        self::assertEquals(
            500,
            $coinBag->last()->flipTails()->getAmount(),
        );
    }
}