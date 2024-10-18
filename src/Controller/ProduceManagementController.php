<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Enum\Unit;
use App\Exception\ProduceExceptionInterface;
use App\Serializer\ProduceSerializer;
use App\Service\CollectionManagementServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProduceManagementController extends AbstractController
{
    #[Route('/add/', name: 'add_new_produce', methods: ['POST'])]
    public function insert(
        #[MapRequestPayload] ProduceInterface $produceInput,
        CollectionManagementServiceInterface $produceManagementService,
        SerializerInterface $serializer
    ): Response {
        try {
            $collection = $produceManagementService->add($produceInput);
        } catch (ProduceExceptionInterface $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST, json: true);
        }

        return new JsonResponse($serializer->serialize($collection, 'json'), Response::HTTP_OK, json: true);
    }

    #[Route('/bulk/', name: 'add_bulk_produce', methods: ['POST'])]
    public function insertBulk(
        Request $request,
        CollectionManagementServiceInterface $produceManagementService,
        SerializerInterface $serializer,
    ): Response {
        $produces = $serializer->deserialize(
            $request->getContent(),
            'App\DTO\ProduceInterface[]',
            'json'
        );

        $collections = $produceManagementService->addBulk($produces);

        return new JsonResponse($serializer->serialize($collections, 'json'), Response::HTTP_OK, json: true);
    }

    #[Route('/list/{type}/', name: 'list_collection', methods: ['GET'])]
    public function list(
        ProduceType $type,
        Request $request,
        CollectionManagementServiceInterface $produceManagementService,
        SerializerInterface $serializer
    ): Response {
        $collection = $produceManagementService->list($type);

        $unit = Unit::tryFrom($request->get('unit') ?? '') ?? Unit::GRAM;

        return new JsonResponse(
            $serializer->serialize(
                $collection,
                'json',
                [
                    ProduceSerializer::CONVERT_TO_KILOGRAM => $unit === Unit::KILOGRAM
                ]
            ),
            Response::HTTP_OK,
            json: true
        );
    }

    #[Route('/{type}/{id}/', name: 'remove_item_', methods: ['DELETE'])]
    public function remove(
        ProduceType $type,
        int $id,
        CollectionManagementServiceInterface $produceManagementService,
    ): Response {
        $produceManagementService->remove($type, $id);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
