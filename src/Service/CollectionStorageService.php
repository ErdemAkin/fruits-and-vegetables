<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\ItemCollectionInterface;
use App\Entity\CollectionEntity;
use App\Enum\ProduceType;
use App\Repository\CollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class CollectionStorageService implements CollectionStorageServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CollectionRepository $repository,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function update(ProduceType $type, ItemCollectionInterface $collection): void
    {
        $entity = $this->repository->findOneBy(['type' => $type->value]);

        if ($entity === null) {
            $entity = new CollectionEntity();
            $entity->setType($type);
        }

        $entityCollection = $this->normalizer->normalize($collection);
        $entity->setCollection($entityCollection);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}