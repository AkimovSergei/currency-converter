<?php

namespace App\Controller;

use App\Repository\ConvertHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConvertHistoryController extends AbstractController
{
    /**
     * @param ConvertHistoryRepository $convertHistoryRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(ConvertHistoryRepository $convertHistoryRepository)
    {
        return $this->json([
            'data' => $convertHistoryRepository->findAll()
        ]);
    }
}
