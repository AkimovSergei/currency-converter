<?php

namespace CurrencyConverter\Providers\CurrencyConverterApi;

use CurrencyConverter\Providers\ProviderInterface;

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
     * @param string $accessKey
     */
    public function __construct(string $accessKey)
    {
        $this->api = new Api($accessKey);
    }

    /**
     * Convert
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param $amount
     * @return float|int
     * @throws Exceptions\ConvertionException
     */
    public function convert(string $fromCurrency, string $toCurrency, $amount)
    {
        return $this->api->convert($fromCurrency, $toCurrency, $amount);
    }
}
