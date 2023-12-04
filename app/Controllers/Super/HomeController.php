<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home da pagina Inicial',
        ];

        return view('Back/Home/index', $data);
    }
}
