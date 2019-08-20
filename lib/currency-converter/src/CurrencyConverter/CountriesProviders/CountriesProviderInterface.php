<?php

declare(strict_types=1);

namespace CurrencyConverter\CountriesProviders;

/**
 * Interface CurrencyProviderInterface
 */
interface CountriesProviderInterface
{

    /**
     * Get currencies for city
     *
     * @param string $city
     * @return mixed
     */
    public function getCurrenciesList(string $city = ''): array;

}
