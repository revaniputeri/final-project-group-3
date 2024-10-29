<?php

namespace PrestaC\App;

class View
{
    public static function render(string $view, $model)
    {
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
