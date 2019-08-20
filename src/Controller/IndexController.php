<?php

namespace App\Controller;

use App\Repository\ConvertHistoryRepository;
use App\Services\Helpers;
use CurrencyConverter\CountriesService;
use CurrencyConverter\CurrencyConverterService;
use CurrencyConverter\CurrencyConvertion;
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
     * @param CountriesService $countriesService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchCity(Request $request, CountriesService $countriesService)
    {
        $currencies = $countriesService->fetchCurrencies(
            $request->query->get('city')
        );

        return $this->json(['data' => $currencies]);
    }

    /**
     * Convert amount
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param ConvertHistoryRepository $convertHistoryRepository
     * @param CurrencyConverterService $currencyConverterService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function convert(
        Request $request,
        ValidatorInterface $validator,
        ConvertHistoryRepository $convertHistoryRepository,
        CurrencyConverterService $currencyConverterService,
        Helpers $helpers
    )
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

        /** @var CurrencyConvertion $convertion */
        $convertion = $currencyConverterService->convert(
            $input['from']['currency'],
            $input['to']['currency'],
            $helpers->parseMoney($input['from']['amount'])
        );

        // Save
        $convertHistoryRepository->save(
            $convertion->getCurrencyFrom(),
            $convertion->getAmountFrom(),
            $convertion->getCurrencyTo(),
            $convertion->getAmountTo(),
            $input['capital'] ?? '',
            $input['country'] ?? ''
        );

        return $this->json(['amount' => $convertion->getAmountTo()]);
    }

}
