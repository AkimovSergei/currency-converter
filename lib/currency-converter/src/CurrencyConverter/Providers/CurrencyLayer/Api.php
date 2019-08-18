<?php

namespace CurrencyConverter\Providers\CurrencyLayer;

use CurrencyConverter\Providers\CurrencyLayer\Exceptions\ConvertionException;

/**
 * Class Api
 *
 * @package CurrencyConverter\Providers\CurrencyLayer
 */
class Api
{

    const HOST = 'apilayer.net/api';

    /** @var string Api access key */
    protected $accessKey;

    /**
     * Api constructor.
     *
     * @param string $accessKey
     */
    public function __construct(string $accessKey)
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey(string $accessKey): void
    {
        $this->accessKey = $accessKey;
    }

    /**
     * Conversion exceptions
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param $amount
     * @return mixed
     * @throws ConvertionException
     */
    public function convert(string $fromCurrency, string $toCurrency, $amount)
    {
        $endpoint = $this->getEndpoint('convert', [
            'access_key' => $this->getAccessKey(),
            'from' => $fromCurrency,
            'to' => $toCurrency,
            'amount' => $amount,
        ]);

        $conversionResult = $this->request($endpoint);

        if (!isset($conversionResult['result'])) {
            throw new ConvertionException("Convertion exception");
        }

        return $conversionResult['result'];
    }

    /**
     * Generate endpoint
     *
     * @param string $method
     * @param array $params
     * @param bool $useHttps
     * @return string
     */
    public function getEndpoint(string $method, array $params = [], bool $useHttps = false): string
    {
        // https is not available for free plan
        $endpoint = $useHttps ? 'https://' : 'http://';

        $endpoint .= static::HOST . '/' . $method;

        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        return $endpoint;
    }

    /**
     * Execute request
     *
     * @param $endpoint
     * @return mixed
     */
    public function request($endpoint)
    {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }

}
