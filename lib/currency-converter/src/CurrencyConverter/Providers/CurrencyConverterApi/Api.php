<?php

namespace CurrencyConverter\Providers\CurrencyConverterApi;

use CurrencyConverter\Providers\CurrencyConverterApi\Exceptions\ConvertionException;

/**
 * Class Api
 */
class Api
{

    const HOST = 'https://free.currconv.com';

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
     * Convert
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param $amount
     * @return float|int
     * @throws ConvertionException
     */
    public function convert(string $fromCurrency, string $toCurrency, $amount)
    {
        $currencyId = $fromCurrency . '_' . $toCurrency;

        $endpoint = $this->getEndpoint([
            'apiKey' => $this->getAccessKey(),
            'q' => $currencyId,
        ]);

        $conversionResult = $this->request($endpoint);

        if (!isset($conversionResult['results'][$currencyId])) {
            throw new ConvertionException('Convertion exception');
        }

        $rate = $conversionResult['results'][$currencyId]['val'] ?? 0;

        return $amount * $rate;
    }

    /**
     * Generate endpoint
     *
     * @param array $params
     * @return string
     */
    public function getEndpoint(array $params = []): string
    {
        // https is not available for free plan
        $endpoint = static::HOST . '/api/v7/convert';

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
