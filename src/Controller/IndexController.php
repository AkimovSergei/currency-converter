<?php

namespace App\Controller;

use App\Repository\ConvertHistoryRepository;
use CurrencyConverter\Currencies;
use CurrencyConverter\CurrenciesProviders\RestCountriesProvider\RestCountryProvider;
use CurrencyConverter\CurrencyConverter;
use CurrencyConverter\Providers\CurrencyConverterApi\Provider as CurrencyConverterApiProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{

    /**
     * Index action
     */
    public function index()
    {
        return $this->render('/index/index.html.twig');
    }

    /**
     * Search city
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchCity(Request $request)
    {
        $currenciesService = new Currencies(new RestCountryProvider);

        $currencies = $currenciesService->fetchCurrencies(
            $request->query->get('city')
        );

        return $this->json(['data' => $currencies]);
    }

    /**
     * Convert amount
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function convert(Request $request, ValidatorInterface $validator, ConvertHistoryRepository $convertHistoryRepository)
    {
        $constraints = new Assert\Collection([
            'fields' => [
                'from' => new Assert\Collection([
                    'fields' => [
                        'currency' => [new Assert\Currency, new Assert\NotBlank],
                        'amount' => [new Assert\Positive, new Assert\NotBlank],
                    ],
                    'allowExtraFields' => true,
                ]),
                'to' => new Assert\Collection([
                    'fields' => [
                        'currency' => [new Assert\Currency, new Assert\NotBlank],
                    ],
                    'allowExtraFields' => true,
                ]),
            ],
            'allowExtraFields' => true,
        ]);

        $input = $request->request->all();

        $violations = $validator->validate($input, $constraints);

        if (0 < $violations->count()) {
            return $this->json(['error' => 'Validation failed'], 400);
        }

        $converter = new CurrencyConverter(
            new CurrencyConverterApiProvider(
                $this->getParameter('currency_converter.currency_converter_api_secret')
            )
        );

        $amount = $converter->convert(
            $input['from']['currency'],
            $input['to']['currency'],
            $input['from']['amount']
        );

        // Save
        $convertHistoryRepository->save(
            $input['from']['currency'],
            $input['from']['amount'],
            $input['to']['currency'],
            $amount,
            $input['capital'] ?? '',
            $input['country'] ?? ''
        );

        return $this->json(['amount' => $amount]);
    }

}
