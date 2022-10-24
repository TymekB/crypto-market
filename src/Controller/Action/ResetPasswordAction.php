<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Form\Type\ChangePasswordFormType;
use App\Message\Command\ResetUserPasswordCommand;
use App\Session\Manager\ResetPasswordSessionManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class ResetPasswordAction
{
    public function __construct(
        private readonly RouterInterface                      $router,
        private readonly MessageBusInterface                  $messageBus,
        private readonly FormFactoryInterface                 $formFactory,
        private readonly ResetPasswordSessionManagerInterface $resetPasswordSessionManager,
        private readonly Environment                          $twig
    )
    {
    }

    public function __invoke(Request $request, ?string $token): Response
    {
        if ($token) {
            $this->resetPasswordSessionManager->storeTokenInSession($token);

            return new RedirectResponse(
                $this->router->generate('reset_password')
            );
        }

        $token = $this->resetPasswordSessionManager->getTokenFromSession();

        if (null === $token) {
            throw new NotFoundHttpException('Token not found');
        }

        $form = $this->formFactory->create(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();

            $this->messageBus->dispatch(
                new ResetUserPasswordCommand($token, $newPassword)
            );

            $this->resetPasswordSessionManager->cleanSessionAfterReset();

            return new RedirectResponse(
                $this->router->generate('login')
            );
        }

        return new Response(
            $this->twig->render('reset_password/reset.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}