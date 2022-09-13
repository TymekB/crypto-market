<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class VerifyUserEmailAction
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response();
    }
}