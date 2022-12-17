<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiHeaderSubscriber implements EventSubscriberInterface
{
    public function addApiHeaders(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        // if ('application/ld+json; charset=utf-8' === $request->getHeaders()['content-type']) {
        if ('application/json' === $event->getRequest()->headers->get('Accept')) {
            $response->headers->set('X-Total-Count', '30');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addApiHeaders',
        ];
    }
}
