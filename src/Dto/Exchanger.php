<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use Brick\Money\ExchangeRateProvider\ConfigurableProvider;
use JetBrains\PhpStorm\Pure;
use TheTahitianPearl\Collector\Util\CurrencyUtil;

class Exchanger
{
    private ConfigurableProvider|null $rulesProvider;

    #[Pure]
    public function __construct()
    {
        $this->rulesProvider = new ConfigurableProvider();
    }

    final public function getRulesProvider(): ConfigurableProvider
    {
        return $this->rulesProvider;
    }

    final public function addRule(string $sourceCurrency, string $targetCurrency, string $exchangeRate): self
    {
        $sourceCurrencyObject = CurrencyUtil::createCurrencyObject($sourceCurrency);
        $targetCurrencyObject = CurrencyUtil::createCurrencyObject($targetCurrency);

        CurrencyUtil::validateCurrency($sourceCurrencyObject);
        CurrencyUtil::validateCurrency($targetCurrencyObject);

        $this->rulesProvider->setExchangeRate(
            $sourceCurrencyObject->getCode(),
            $targetCurrencyObject->getCode(),
            $exchangeRate
        );

        return $this;
    }
}