<?php

namespace CurrencyConverter;

use CurrencyConverter\CurrenciesProviders\CurrencyProviderInterface;

/**
 * Class Currencies
 * @package CurrencyConverter
 */
class Currencies
{

    /** @var CurrencyProviderInterface */
    protected $currencyProvider;

    /**
     * Currencies constructor.
     *
     * @param CurrencyProviderInterface $currencyProvider
     */
    public function __construct(CurrencyProviderInterface $currencyProvider)
    {
        $this->currencyProvider = $currencyProvider;
    }

    /**
     * @param $city
     * @return mixed
     */
    public function fetchCurrencies(string $city)
    {
        return $this->currencyProvider->getCurrenciesList($city);
    }

}
