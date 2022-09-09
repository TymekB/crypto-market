<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Command\CreateUserCommand;
use App\Dto\UserDto;
use App\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RegisterUserAction
{
    public function __construct(
        private readonly Environment          $twig,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface  $messageBus,
        private readonly RouterInterface      $router
    ) {}

    public function __invoke(Request $request)
    {
        $userDto = new UserDto();

        $form = $this->formFactory->create(RegistrationFormType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createUserCommand = new CreateUserCommand(
                $userDto->getEmail(),
                $userDto->getPassword()
            );

            $this->messageBus->dispatch($createUserCommand);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Account was successfully created. Before logging in confirm your email');

            return new RedirectResponse($this->router->generate('login'));
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