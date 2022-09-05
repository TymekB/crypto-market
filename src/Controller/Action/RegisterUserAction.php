<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Command\CreateUserCommand;
use App\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Twig\Environment;

final class RegisterUserAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface $messageBus
    ) {}

    public function __invoke(Request $request)
    {
        $form = $this->formFactory->create(RegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $createUserCommand = new CreateUserCommand(
                $form->get('email')->getData(),
                $form->get('password')->getData()
            );

            $this->messageBus->dispatch($createUserCommand);
        }

        return new Response(
            $this->twig->render('register.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }
}