<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto\Money;

use JetBrains\PhpStorm\Pure;
use Money\Currency;
use Money\Money;
use Brick\Money\Money as BrickMoney;
use NumberToWords\NumberToWords;
use TheTahitianPearl\Collector\Dto\Countries\CoinCirculation;
use TheTahitianPearl\Collector\Util\CountryUtil;
use TheTahitianPearl\Collector\Util\CurrencyUtil;

class Coin
{
    public const COIN_MATERIAL_BRONZE = 'bronze';
    public const COIN_MATERIAL_SILVER = 'silver';
    public const COIN_MATERIAL_RUBY = 'ruby';
    public const COIN_MATERIAL_GOLD = 'gold';
    public const COIN_MATERIAL_DIAMOND = 'diamond';
    public const COIN_MATERIAL_PLATINUM = 'platinum';
    public const COIN_MATERIAL_PALLADIUM = 'palladium';
    public const COIN_MATERIAL_KRYPTONITE = 'kryptonite';

    private Money $tails;

    private Currency $heads;

    private CoinCirculation $coinCirculation;

    private CoinBag $coinBag;

    public function __construct(string $stampHeads, int|string $stampTails = 0)
    {
        $currency = new Currency($stampHeads);
        CurrencyUtil::validateCurrency($currency);

        $money = new Money($stampTails, $currency);

        $this->tails = $money;
        $this->heads = $currency;

        CountryUtil::setCountryOfCoin($this);
    }

    final public function flipTails(): Money
    {
        return $this->tails;
    }

    final public function flipHeads(): Currency
    {
        return $this->heads;
    }

    final public function hasValue(): bool
    {
        return $this->tails->isZero() || $this->tails->isNegative();
    }

    final public function upgradeValue(string|int $amount): void
    {
        $this->tails = $this->tails->add(
            new Money($amount, $this->heads)
        );
    }

    final public function decreaseValue(string|int $amount): void
    {
        $this->tails = $this->tails->subtract(
            new Money($amount, $this->heads)
        );
    }

    final public function getValueInWords(string $language = 'en'): string
    {
        $numberToWords = new NumberToWords();
        $currencyTransformer = $numberToWords->getCurrencyTransformer($language);

        return $currencyTransformer->toWords(
            (int)$this->tails->getAmount(),
            $this->heads->getCode()
        );
    }

    final public function getValue(string $format = 'en_US'): string
    {
        $money = BrickMoney::of(
            (int)$this->flipTails()->getAmount(),
            $this->flipHeads()->getCode()
        );

        return $money->formatTo($format);
    }

    #[Pure]
    final public function isBronze(): bool
    {
        return $this->tails->getAmount() <= 1000;
    }

    #[Pure]
    final public function isSilver(): bool
    {
        return $this->tails->getAmount() <= 5000;
    }

    #[Pure]
    final public function isGold(): bool
    {
        return $this->tails->getAmount() <= 10000;
    }

    #[Pure]
    final public function isDiamond(): bool
    {
        return $this->tails->getAmount() <= 100000;
    }

    #[Pure]
    final public function isPlatinum(): bool
    {
        return $this->tails->getAmount() <= 1000000;
    }

    #[Pure]
    final public function isPalladium(): bool
    {
        return $this->tails->getAmount() > 1000000 && $this->tails->getAmount()  < 10000000;
    }

    #[Pure]
    final public function isKryptonite(): bool
    {
        return $this->tails->getAmount() >= 10000000;
    }

    #[Pure]
    final public function getMaterial(): string
    {
        $value = $this->tails->getAmount();

        return match (true) {
            $value <= 1000 => self::COIN_MATERIAL_SILVER,
            $value <= 5000 => self::COIN_MATERIAL_RUBY,
            $value <= 10000 => self::COIN_MATERIAL_GOLD,
            $value <= 100000 => self::COIN_MATERIAL_DIAMOND,
            $value <= 1000000 => self::COIN_MATERIAL_PLATINUM,
            $value > 1000000 && $value < 10000000 => self::COIN_MATERIAL_PALLADIUM,
            $value >= 10000000 => self::COIN_MATERIAL_KRYPTONITE,
            default => self::COIN_MATERIAL_BRONZE
        };
    }

    final public function getCoinCirculation(): CoinCirculation
    {
        return $this->coinCirculation;
    }

    final public function setCoinCirculation(CoinCirculation $coinCirculation): self
    {
        $this->coinCirculation = $coinCirculation;

        return $this;
    }

    final public function getCoinBag(): CoinBag
    {
        return $this->coinBag;
    }

    final public function setCoinBag(CoinBag $coinBag): self
    {
        $this->coinBag = $coinBag;

        return $this;
    }
}