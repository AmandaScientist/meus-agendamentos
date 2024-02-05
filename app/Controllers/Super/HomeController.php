<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        // Carrega o helper 'url' para utilizar a função base_url()
        helper(['url']);

        // Array associativo contendo dados para serem passados para a visão
        $data = [
            'title' => 'Bem - Vindo(a)! ao Sistema de Agendamento Online - SISAGENDA',
        ];

        // Carrega a folha de estilos usando a função link_tag()
        $data['styles'] = link_tag('css/styles.css');

        // Retorna a visão 'Back/Home/index' com os dados
        return view('Back/Home/index', $data);
    }
}
