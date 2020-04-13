<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class HttpLoggerEventListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->setLogger(new NullLogger());
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->logger->info('Processing request', [
            'host' => $event->getRequest()->getHost(),
            'method' => $event->getRequest()->getMethod(),
            'body' => (string) $event->getRequest()->getContent(),
            'headers' => $event->getRequest()->headers->all(),
        ]);
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $this->logger->info('Sending response', [
            'status_code' => $event->getResponse()->getStatusCode(),
            'body' => (string) $event->getResponse()->getContent(),
        ]);
    }
}
