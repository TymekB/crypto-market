<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ShowDashboardAction
{
    public function __construct(private Environment $twig)
    {
    }


    public function __invoke(): Response
    {
        return new Response($this->twig->render('dashboard.html.twig'));
    }

}