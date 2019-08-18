<?php

namespace CurrencyConverter\CurrenciesProviders;

/**
 * Interface CurrencyProviderInterface
 */
interface CurrencyProviderInterface
{

    /**
     * Get currencies for city
     *
     * @param string $city
     * @return mixed
     */
    public function getCurrenciesList(string $city = '');

}
