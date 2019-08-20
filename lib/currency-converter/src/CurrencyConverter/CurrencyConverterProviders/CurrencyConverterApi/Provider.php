<?php

declare(strict_types=1);

namespace CurrencyConverter\CurrencyConverterProviders\CurrencyConverterApi;

use CurrencyConverter\CurrencyConverterProviders\ProviderInterface;
use CurrencyConverter\CurrencyConvertion;

/**
 * Class Provider
 */
class Provider
    implements ProviderInterface
{

    /** @var Api */
    protected $api;

    /**
     * Provider constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Convert
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param float $amount
     * @return CurrencyConvertion
     * @throws Exceptions\ConvertionException
     */
    public function convert(string $fromCurrency, string $toCurrency, float $amount): CurrencyConvertion
    {
        $amountTo = $this->api->convert($fromCurrency, $toCurrency, $amount);

        return new CurrencyConvertion($fromCurrency, $amount, $toCurrency, $amountTo);
    }

}
