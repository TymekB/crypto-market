<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class RegisterUserAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly FormFactoryInterface $formFactory
    ) {}


    public function __invoke()
    {
        $form = $this->formFactory->create(RegistrationFormType::class);

        return new Response(
            $this->twig->render('register.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }

}