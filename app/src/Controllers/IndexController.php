<?php

namespace PrestaC\Controllers;

use PrestaC\App\View;

class IndexController 
{
    public function dashboard()
    {
        View::render('dashboard', '');
    }

    
}