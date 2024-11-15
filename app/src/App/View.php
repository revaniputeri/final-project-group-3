<?php

namespace PrestaC\App;

class View
{
    public static function render(string $view, $model)
    {
        require __DIR__ . '/../Views/partials/head.php';
        require __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/partials/footer.php';
    }
}
