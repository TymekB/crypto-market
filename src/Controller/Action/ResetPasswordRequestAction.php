<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Form\Type\ResetPasswordRequestFormType;
use App\Message\Command\ResetUserPasswordCommand;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Twig\Environment;

final class ResetPasswordRequestAction
{
    public function __construct(
        private readonly Environment          $twig,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface  $commandBus
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userEmail = $form->get('email')->getData();

            $this->commandBus->dispatch(
                new ResetUserPasswordCommand($userEmail)
            );
        }

        return new Response(
            $this->twig->render('reset_password/request.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}