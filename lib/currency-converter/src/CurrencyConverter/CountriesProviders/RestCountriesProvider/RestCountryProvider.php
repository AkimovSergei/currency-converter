<?php

declare(strict_types=1);

namespace CurrencyConverter\CountriesProviders\RestCountriesProvider;

use CurrencyConverter\CountriesProviders\CountriesProviderInterface;

/**
 * Class RestCountryProvider
 * @package CurrencyConverter\CountriesProviders\RestCountriesProvider
 */
class RestCountryProvider
    implements CountriesProviderInterface
{

    /** @var Api */
    protected $api;

    /**
     * RestCountryProvider constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Get currencies list
     *
     * @param string $city
     * @return array
     */
    public function getCurrenciesList(string $city = ''): array
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
