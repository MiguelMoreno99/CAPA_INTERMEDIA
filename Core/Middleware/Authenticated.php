<?php

namespace Core\Middleware;

class Authenticated
{
    public function handle()
    {
        if (! $_SESSION['usuario'] ?? false) {
            header('location: /');
            exit();
        }
    }
}