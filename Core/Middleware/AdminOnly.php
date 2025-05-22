<?php

namespace Core\Middleware;

class AdminOnly
{
    public function handle()
    {
        if (! $_SESSION['usuario'] || $_SESSION['usuario']['tipo_usuario'] !== 1 ?? false) {
            header('location: /');
            exit();
        }
    }
}