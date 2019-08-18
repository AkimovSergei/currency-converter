<?php

namespace CurrencyConverter\CurrenciesProviders\RestCountriesProvider;

use CurrencyConverter\CurrenciesProviders\CurrencyProviderInterface;

/**
 * Class RestCountryProvider
 * @package CurrencyConverter\CurrencyProviders\RestCountriesProvider
 */
class RestCountryProvider
    implements CurrencyProviderInterface
{

    /** @var Api */
    protected $api;

    /**
     * RestCountryProvider constructor.
     */
    public function __construct()
    {
        $this->api = new Api;
    }

    /**
     * Get currencies list
     *
     * @param string $city
     * @return array
     */
    public function getCurrenciesList(string $city = '')
    {

        $filters = [
            'fields' => 'name;currencies;capital',
            'fullText' => 'true'
        ];

        if (!empty($city)) {
            $items = $this->api->findCapital($city, $filters);
        } else {
            $items = $this->api->get($filters);
        }

        $currencies = [];

        foreach ($items as $country) {
            if (!empty($country['currencies'])) {
                foreach ($country['currencies'] as $currency) {
                    if (isset($currency['code']) && '(none)' !== $currency['code']) {
                        $currencies[$currency['code']] = array_merge($currency, [
                            'capital' => $country['capital'],
                            'country' => $country['name'],
                        ]);
                    }
                }
            }
        }

        // Sort by name
        usort($currencies, function ($left, $right) {
            return $left['code'] <=> $right['code'];
        });

        return $currencies;
    }

}
