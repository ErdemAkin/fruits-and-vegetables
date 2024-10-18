<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\ProduceExceptionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $message = 'Unexpected Exception';
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($exception instanceof ProduceExceptionInterface) {
            $message = $exception->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        $res = new JsonResponse(
            $message,
            $statusCode,
        );
        $event->setResponse($res);
    }
}