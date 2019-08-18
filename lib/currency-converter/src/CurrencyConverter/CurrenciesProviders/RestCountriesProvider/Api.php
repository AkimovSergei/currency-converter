<?php

namespace CurrencyConverter\CurrenciesProviders\RestCountriesProvider;


/**
 * Class Api
 * @package CurrencyConverter\CurrencyProviders\RestCountriesProvider
 */
class Api
{

    const ENDPOINT = 'https://restcountries.eu/rest/v2';

    /**
     * Get all currencies
     *
     * @param array $filters
     * @return mixed
     */
    public function get(array $filters = [])
    {
        $endpoint = $this->getEndpoint('/all', $filters);

        return $this->request($endpoint);
    }

    public function findCapital($city, array $filters = [])
    {
        $endpoint = $this->getEndpoint('/capital/' . urlencode(mb_strtolower($city)), $filters);

        return $this->request($endpoint);
    }

    /**
     * @param string $method
     * @param array $params
     * @return string
     */
    public function getEndpoint(string $method, array $params = []): string
    {
        $endpoint = static::ENDPOINT . $method;

        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        return $endpoint;
    }

    public function request($endpoint)
    {
        $curl = curl_init($endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}
