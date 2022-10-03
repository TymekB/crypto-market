<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[AsEventListener(event: ExceptionEvent::class)]
final class ExceptionEventListener
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $flashbag = $event->getRequest()->getSession()->getFlashbag();

        if ($exception->getPrevious() instanceof VerifyEmailExceptionInterface) {
            $flashbag->add('danger', 'Something went wrong with verifying your email. Try again later.');

            $response = new RedirectResponse(
                $this->router->generate('login')
            );
            $event->setResponse($response);
        }
    }
}