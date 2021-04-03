<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test\Service;

use Money\Money;
use PHPUnit\Framework\TestCase;
use TheTahitianPearl\Collector\Dto\TreasureChest;
use TheTahitianPearl\Collector\Service\MoneyService;

/**
 * @group calculation
 */
final class MoneyServiceTest extends TestCase
{
    /**
     * @test
     */
    public function multi_append_to_money_object(): void
    {
        $swagger = Money::EUR(100);

        $treasureChest = new TreasureChest();
        $treasureChest->setMoneyBags([
            Money::EUR(1000),
            Money::EUR(30),
            Money::EUR(1),
        ]);

        $moneyService = new MoneyService();
        $swagger = $moneyService->multiCalculation(
            method: MoneyService::APPEND,
            swagger: $swagger,
            treasureChest: $treasureChest
        );

        $this->assertEquals($swagger, Money::EUR(1131));
    }

    /**
     * @test
     */
    public function multi_subtraction_from_money_object(): void
    {
       $swagger = Money::EUR(100);

       $treasureChest = new TreasureChest();
       $treasureChest->setMoneyBags([
         Money::EUR(10),
         Money::EUR(5),
         Money::EUR(20),
       ]);

       $moneyService = new MoneyService();
       $swagger = $moneyService->multiCalculation(
           method: MoneyService::SUBTRACT,
           swagger: $swagger,
           treasureChest: $treasureChest
       );
       $this->assertEquals($swagger, Money::EUR(65));
    }

    /**
     * @test
     */
    public function money_bags_have_same_valuta(): void
    {
        $treasureChest = new TreasureChest();
        $treasureChest->setMoneyBags([
            Money::USD(1000),
            Money::USD(30),
            Money::USD(1),
        ]);

        $moneyService = new MoneyService();
        $this->assertTrue($moneyService->hasSameValutaMoneyBags($treasureChest));
    }

    /**
     * @test
     */
    public function money_bags_do_not_have_same_valuta(): void
    {
        $treasureChest = new TreasureChest();
        $treasureChest->setMoneyBags([
            Money::USD(1000),
            Money::EUR(30),
            Money::RUB(1),
        ]);

        $moneyService = new MoneyService();
        $this->assertFalse($moneyService->hasSameValutaMoneyBags($treasureChest));
    }
}