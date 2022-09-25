<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Form\Type\ResetPasswordRequestFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ResetPasswordRequestAction
{
    public function __construct(
        private readonly Environment          $twig,
        private readonly FormFactoryInterface $formFactory
    )
    {
    }


    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        return new Response(
            $this->twig->render('reset_password/request.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        );
    }

}