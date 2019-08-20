<?php

declare(strict_types=1);

namespace CurrencyConverter\CurrencyConverterProviders;

use CurrencyConverter\CurrencyConvertion;

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
     * @param float $amount
     * @return CurrencyConvertion
     */
    public function convert(string $fromCurrency, string $toCurrency, float $amount): CurrencyConvertion;

}
