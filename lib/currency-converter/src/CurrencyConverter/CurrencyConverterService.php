<?php

declare(strict_types=1);

namespace CurrencyConverter;

use CurrencyConverter\CurrencyConverterProviders\ProviderInterface;

/**
 * Class Converter
 * @package CurrencyConverter
 */
class CurrencyConverterService
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
     * @return CurrencyConverterService
     */
    public function setProvider(ProviderInterface $provider): CurrencyConverterService
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Convert amount
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param float $amount
     * @return CurrencyConvertion
     */
    public function convert(string $fromCurrency, string $toCurrency, float $amount): CurrencyConvertion
    {
        return $this->getProvider()->convert($fromCurrency, $toCurrency, $amount);
    }

}
