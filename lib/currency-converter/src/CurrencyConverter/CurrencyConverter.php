<?php

namespace CurrencyConverter;

use CurrencyConverter\Providers\ProviderInterface;

/**
 * Class Converter
 * @package CurrencyConverter
 */
class CurrencyConverter
{

    /** @var ProviderInterface */
    protected $provider;

    /**
     * Converter constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider(): ProviderInterface
    {
        return $this->provider;
    }

    /**
     * @param ProviderInterface $provider
     * @return CurrencyConverter
     */
    public function setProvider(ProviderInterface $provider): CurrencyConverter
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Convert amount
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param $amount
     * @return mixed
     */
    public function convert(string $fromCurrency, string $toCurrency, $amount)
    {
        return $this->getProvider()->convert($fromCurrency, $toCurrency, $amount);
    }

}
