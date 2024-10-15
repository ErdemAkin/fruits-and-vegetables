<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ProduceType;
use App\Repository\CollectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: CollectionRepository::class)]
#[Table(name: 'collection')]
class CollectionEntity
{
    #[ORM\Id]
    #[ORM\Column(unique: true, options: ['unsigned' => true])]
    #[ORM\GeneratedValue]
    private readonly int $id;

    #[ORM\Column]
    protected ProduceType $type;

    #[ORM\Column(type: Types::JSON)]
    protected array $collection;

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function setCollection(array $collection): void
    {
        $this->collection = $collection;
    }

    public function getType(): ProduceType
    {
        return $this->type;
    }

    public function setType(ProduceType $type): void
    {
        $this->type = $type;
    }
}