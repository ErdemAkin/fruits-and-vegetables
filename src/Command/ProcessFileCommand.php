<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CollectionManagementService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'app:create-collection')]
class ProcessFileCommand extends Command
{
    public function __construct(
        private SerializerInterface $serializer,
        private CollectionManagementService $collectionManagementService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path of request json file',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        if (!file_exists($path . '/request.json')) {
            $output->writeln('Request json file not found');
            return Command::FAILURE;
        }

        $produces = file_get_contents($path . '/request.json');
        $produces = $this->serializer->deserialize(
            $produces,
            'App\DTO\ProduceInterface[]',
            'json'
        );

        $this->collectionManagementService->addBulk($produces);

        return Command::SUCCESS;
    }
}