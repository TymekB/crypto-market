<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Twig\Environment;

final class ShowDashboardAction
{
    public function __construct(private Environment $twig)
    {
    }


    public function __invoke()
    {

    }

}