<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test\Dto;

use Money\Money;
use PHPUnit\Framework\TestCase;
use TheTahitianPearl\Collector\Dto\TreasureChest;

/**
 * @group dto
 */
final class TreasureChestTest extends TestCase
{
    /**
     * @test
     */
    public function is_filled_with_money_objects(): void
    {
        $treasureChest = new TreasureChest();
        $treasureChest->setMoneyBags([
            Money::EUR(1000),
            Money::EUR(30),
            Money::EUR(1),
        ]);


        $this->assertTrue($treasureChest->isFilled());
    }

    /**
     * @test
     */
    public function is_empty(): void
    {
        $treasureChest = new TreasureChest();

        $this->assertFalse($treasureChest->isFilled());
    }
}