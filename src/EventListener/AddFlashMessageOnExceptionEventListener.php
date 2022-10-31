<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\RouterInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\TooManyPasswordRequestsException;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[AsEventListener(event: ExceptionEvent::class)]
final class AddFlashMessageOnExceptionEventListener
{
    public function __construct(private readonly RouterInterface $router)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $flashbag = $event->getRequest()->getSession()->getFlashbag();

        if ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        if ($exception instanceof VerifyEmailExceptionInterface) {
            $flashbag->add(
                'danger',
                'Something went wrong with verifying your email. Try again later.'
            );

            $response = new RedirectResponse(
                $this->router->generate('login')
            );
            $event->setResponse($response);
        }

        if ($exception instanceof TooManyPasswordRequestsException) {
            $flashbag->add(
                'danger',
                'You need to wait at least 5 minutes before another password reset attempt.'
            );

            $response = new RedirectResponse(
                $this->router->generate('reset_password_request')
            );
            $event->setResponse($response);
        }
    }
}