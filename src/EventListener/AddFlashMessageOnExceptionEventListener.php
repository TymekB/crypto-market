<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\User\UserNotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\RouterInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
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
            $flashbag->add('danger', $exception->getReason());

            $response = new RedirectResponse(
                $this->router->generate('login')
            );
            $event->setResponse($response);
        }

        if ($exception instanceof ResetPasswordExceptionInterface) {
            $flashbag->add('danger', $exception->getReason());

            $response = new RedirectResponse(
                $this->router->generate('reset_password_request')
            );
            $event->setResponse($response);
        }

        if($exception instanceof UserNotFoundException) {
            $flashbag->add('danger', $exception->getMessage());

            $response = new RedirectResponse(
                $this->router->generate('reset_password_request')
            );
            $event->setResponse($response);
        }
    }
}