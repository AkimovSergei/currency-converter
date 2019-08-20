<?php

declare(strict_types=1);

namespace CurrencyConverter;

use CurrencyConverter\CountriesProviders\CountriesProviderInterface;

/**
 * Class Currencies
 * @package CurrencyConverter
 */
class CountriesService
{

    /** @var CountriesProviderInterface */
    protected $currencyProvider;

    /**
     * Currencies constructor.
     *
     * @param CountriesProviderInterface $currencyProvider
     */
    public function __construct(CountriesProviderInterface $currencyProvider)
    {
        $this->currencyProvider = $currencyProvider;
    }

    /**
     * Get currencies for country by city name
     *
     * @param $city
     * @return array
     */
    public function fetchCurrencies(string $city): array
    {
        return $this->currencyProvider->getCurrenciesList($city);
    }

}
