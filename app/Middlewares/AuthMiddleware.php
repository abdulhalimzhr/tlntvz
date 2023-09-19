<?php

require_once './Middlewares/MiddlewareAbstract.php';

class AuthMiddleware implements MiddlewareAbstract
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
        }

        return true;
    }
}
