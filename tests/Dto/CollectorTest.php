<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Test\Dto;

use LogicException;
use Money\Money;
use PHP_IBAN\IBAN;
use PHPUnit\Framework\TestCase;
use TheTahitianPearl\Collector\Dto\Collector;
use TheTahitianPearl\Collector\Iterator\BankAccountIterator;
use TheTahitianPearl\Collector\Iterator\MoneyBagIterator;

/**
 * @group dto
 */
final class CollectorTest extends TestCase
{
    private const DUMMY_IBAN = 'NLXXXXXX9897151745';

    /**
     * @test
     */
    public function collector_is_filled_with_objects(): void
    {
        $moneyBag = [Money::EUR(1000)];
        $moneyBagIterator = new MoneyBagIterator($moneyBag);

        $bankAccounts = [new IBAN(self::DUMMY_IBAN)];
        $bankAccountIterator = new BankAccountIterator($bankAccounts);

        $collector = new Collector();
        $collector
            ->setMoneyBagIterator($moneyBagIterator)
            ->setBankAccountsIterator($bankAccountIterator);

        self::assertTrue(
            $collector->isFilled()
        );

        self::assertFalse(
            $collector->isEmpty()
        );
    }

    /**
     * @test
     */
    public function collector_is_empty(): void
    {
        $moneyBagIterator = new MoneyBagIterator([]);
        $bankAccountIterator = new BankAccountIterator([]);

        $collector = new Collector();
        $collector
            ->setMoneyBagIterator($moneyBagIterator)
            ->setBankAccountsIterator($bankAccountIterator);

        self::assertFalse(
            $collector->isFilled()
        );

        self::assertTrue(
            $collector->isEmpty()
        );
    }

    /**
     * @test
     */
    public function has_one_or_more_bank_accounts(): void
    {
        $collector = new Collector();

        $bankAccountIterator = new BankAccountIterator([
            new IBAN(self::DUMMY_IBAN)
        ]);
        $collector->setBankAccountsIterator($bankAccountIterator);

        self::assertTrue($collector->hasBankAccounts());

        $collector->getBankAccountIterator()->clear();

        self::assertCount(
            0 ,
            $collector->getBankAccountIterator()
        );

        $bankAccountIterator = new BankAccountIterator([
            new IBAN(self::DUMMY_IBAN),
            new IBAN(self::DUMMY_IBAN),
        ]);
        $collector->setBankAccountsIterator($bankAccountIterator);

        self::assertTrue($collector->hasBankAccounts());
    }

    /**
     * @test
     */
    public function has_no_bank_accounts(): void
    {
        $collector = new Collector();

        $bankAccountIterator = new BankAccountIterator([]);
        $collector->setBankAccountsIterator($bankAccountIterator);

        self::assertFalse($collector->hasBankAccounts());
    }

    /**
     * @test
     */
    public function get_highest_value_from_money_bag(): void
    {
        $moneyBag = [
            Money::EUR(1000),
            Money::EUR(50),
            Money::EUR(10002),
            Money::EUR(999),
            Money::EUR(10001),
        ];
        $moneyBagIterator = new MoneyBagIterator($moneyBag);

        $collector = new Collector();
        $collector->setMoneyBagIterator($moneyBagIterator);

        self::assertEquals(
            Money::EUR(10002)->getAmount(),
            $collector->getHighestMoneyObjectFromMoneyBag()->getAmount()
        );

        self::assertEquals(
            Money::EUR(10002)->getAmount(),
            $collector->getHighestMoneyAmountFromMoneyBag()
        );
    }

    /**
     * @test
     */
    public function failed_getting_highest_value_from_money_bag_cause_of_divers_currency(): void
    {
        $moneyBag = [
            Money::EUR(1000),
            Money::EUR(50),
            Money::EUR(10002),
            Money::JPY(999),
            Money::EUR(10001),
        ];
        $moneyBagIterator = new MoneyBagIterator($moneyBag);

        $collector = new Collector();
        $collector->setMoneyBagIterator($moneyBagIterator);

        $this->expectException(LogicException::class);
        $collector->getHighestMoneyObjectFromMoneyBag()->getAmount();

        $this->expectException(LogicException::class);
        $collector->getHighestMoneyAmountFromMoneyBag();
    }
}