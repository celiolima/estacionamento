<?php

defined('BASEPATH') or exit('Ação não permitida');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }

        $this->load->model('core_model');
        $this->load->model('home_model');
        $this->load->model('estacionar_model');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index()
    {
        /* echo "</pre>";
        print_r("  voçê esta na home");
        echo "</pre>";
        exit; */

        $data = array(
            'titulo' => 'Você está na Home',
            'info_pagina_atual' => 'Bem vindo ao STE Park!',
            'pagina_atual' => 'Home',
            'icone_pagina' => 'ik-home',
            'styles' => array(
                'dist/css/home.css'
            ),
            'veiculos_estacionados' => $this->estacionar_model->get_all(),
            'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1), // 1 = Carro pequeno
            'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),
            'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(2), // 2 = Carro Médio
            'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 2)),
            'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(3), // 3 = Carro grande
            'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 3)),
            'numero_vagas_moto' => $this->estacionar_model->get_numero_vagas(5), // 5 = Moto
            'vagas_ocupadas_moto' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 5)),


            'numero_total_vagas' => $this->home_model->get_total_vagas(),


            'total_mensalidades' => $this->home_model->get_total_receber(),
            'total_mensalidades_receber' => $this->home_model->count_all('mensalidades', array('mensalidade_status' => 0)),
            'total_mensalidades_pagas' => $this->home_model->count_all('mensalidades', array('mensalidade_status' => 1)),

            'total_avulsos' => $this->home_model->get_total_avulsos(),
            'total_avulsos_pagos' => $this->home_model->count_all('estacionar', array('estacionar_status' => 1)),
            'total_avulsos_abertos' => $this->home_model->count_all('estacionar', array('estacionar_status' => 0)),


            'total_estacionados_agora' => $this->home_model->count_all('estacionar', array('estacionar_status' => 0)),

            'numero_total_mensalistas' => $this->home_model->count_all('mensalistas'),

            'mensalistas_ativos' => $this->home_model->count_all('mensalistas', array('mensalista_ativo' => 1)),
            'mensalistas_inativos' => $this->home_model->count_all('mensalistas', array('mensalista_ativo' => 0)),
        );

        //echo '<pre>';
        //print_r($data['mensalidades_vencidas']);
        //exit();

        $contador = 0;

        if ($this->home_model->get_mensalidades_vencidas()) {
            $data['mensalidades_vencidas'] = TRUE; //Setando a variável
            $contador++;
        }

        if ($this->core_model->get_by_id('precificacoes', array('precificacao_ativa' => 0))) {
            $data['precificacoes_desativadas'] = TRUE; //Setando a variável
            $contador++;
        }

        if ($this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_ativa' => 0))) {
            $data['formas_pagamentos_desativadas'] = TRUE; //Setando a variável
            $contador++;
        }

        //echo '<pre>';
        //echo $contador;
        //exit();


        if ($contador > 0) {
            $data['contador'] = $contador;
        }

        $this->load->view('layout/header', $data);
        $this->load->view('home/home');
        $this->load->view('layout/footer');
    }
}
