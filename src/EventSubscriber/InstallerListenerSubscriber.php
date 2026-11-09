<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InstallerListenerSubscriber implements EventSubscriberInterface
{
    public function onRequestEvent(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        $installedFile = $this->projectDir.'/var/installed.lock';

        // Application is already installed
        if (file_exists($installedFile)) {
            return;
        }

        // Don't redirect the installer to itself
        // And when in dev, we want the profiler to run
        if (preg_match('/(app_installer|profiler)/', $request->attributes->get('_route') ?? '')) {
            return;
        }

        $url = $this->urlGenerator->generate('app_installer');

        $event->setResponse(new RedirectResponse($url));
    }

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private $projectDir,
        // private readonly string $projectDir,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onRequestEvent',
        ];
    }
}
