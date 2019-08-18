<?php

namespace CurrencyConverter\Providers;

/**
 * Interface ProviderInterface
 */
interface ProviderInterface
{

    /**
     * Convert
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param $amount
     * @return mixed
     */
    public function convert(string $fromCurrency, string $toCurrency, $amount);

}
