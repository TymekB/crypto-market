<?php

namespace App\Session\Manager;

interface ResetPasswordSessionManagerInterface
{
    public function storeTokenInSession(string $token);

    public function getTokenFromSession();

    public function getTokenObjectFromSession();

    public function cleanSessionAfterReset();
}