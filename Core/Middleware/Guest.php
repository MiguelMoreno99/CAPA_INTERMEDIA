<?php

namespace Core\Middleware;

class Guest
{
    public function handle()
    {
        if ($_SESSION['usuario'] ?? false) {
            header('location: /');
            exit();
        }
    }
}