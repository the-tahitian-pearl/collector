<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Util;

use TheTahitianPearl\Collector\Dto\Countries\CoinCirculation;
use TheTahitianPearl\Collector\Dto\Countries\Country;
use TheTahitianPearl\Collector\Dto\Money\Coin;

class CountryUtil
{
    final public static function getAllCountries(): array
    {
        return countries();
    }

    final public static function setCountryOfCoin(Coin $coin): void
    {
        $countries = self::getAllCountries();

        $countriesData = array_filter($countries, static function (array $countryData) use ($coin) {
            if ($countryData['currency'] === false) {
                return false;
            }

            if(strtolower($countryData['currency']) === strtolower($coin->flipHeads()->getCode())) {
                return true;
            }

            return false;
        });

        $countries = [];
        foreach ($countriesData as $countryData) {
            $country = new Country();
            $country
                ->setName($countryData['name'])
                ->setOfficialName($countryData['official_name'])
                ->setNativeName($countryData['native_name'])
                ->setNativeOfficialName($countryData['native_official_name'])
                ->setIsoAlpha2($countryData['iso_3166_1_alpha2'])
                ->setIsoAlpha3($countryData['iso_3166_1_alpha3'])
                ->setCurrency($coin->flipHeads())
                ->setEmoji($countryData['emoji']);

            $countries[] = $country;
        }

        $coinCirculation = new CoinCirculation($countries);
        $coin->setCoinCirculation($coinCirculation);
    }
}