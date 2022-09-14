<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Message\Command\VerifyUserEmailCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

final class VerifyUserEmailAction
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly RouterInterface     $router,
    ) {}

    public function __invoke(Request $request): Response
    {
        $userId = $request->get('id');

        if ($userId === null) {
            throw new NotFoundHttpException("User id not found");
        }

        $this->messageBus->dispatch(
            new VerifyUserEmailCommand($userId, $request->getUri()
        ));

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Your e-mail address has been verified.');

        return new RedirectResponse(
            $this->router->generate('login')
        );
    }
}