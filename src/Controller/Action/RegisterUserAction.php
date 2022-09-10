<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Dto\UserDto;
use App\Form\Type\RegistrationFormType;
use App\Message\Command\CreateUserCommand;
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
    ){}

    public function __invoke(Request $request)
    {
        $userDto = new UserDto();

        $form = $this->formFactory->create(RegistrationFormType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->dispatch(CreateUserCommand::fromDto($userDto));

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