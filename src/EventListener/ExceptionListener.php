<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\EventListener;

use Ptyhard\JsonSchemaBundle\Exception\ValidationFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (false === $exception instanceof ValidationFailedException) {
            return;
        }

        $response = new JsonResponse($exception->getErrors(), 400);
        $event->stopPropagation();
        $event->setResponse($response);
    }
}
