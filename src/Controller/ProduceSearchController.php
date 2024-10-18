<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Filter\FilterInterface;
use App\Service\CollectionSearchServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProduceSearchController extends AbstractController
{
    #[Route('/search/', name: 'search_produce', methods: ['POST'])]
    public function insert(
        #[MapRequestPayload] FilterInterface $filter,
        CollectionSearchServiceInterface $collectionSearchService,
        SerializerInterface $serializer
    ): Response {
        $item = $collectionSearchService->search($filter);

        return new JsonResponse($serializer->serialize($item, 'json'), Response::HTTP_OK, json: true);
    }
}
