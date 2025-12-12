<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Precificacoes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }


        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
            redirect('home');
        }

        $this->load->model('core_model');
    }

    public function index() {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
            redirect('home');
        }

        $data = array(
            'titulo' => 'Listando todas as precificações cadastradas',
            'pagina_atual' => 'Precificação',
            'info_pagina_atual' => 'Listando todas as precificações cadastradas',
            'icone_pagina' => 'ik-dollar-sign',
            'styles' => array(
                'plugins/datatables/datatables.net-bs4/css/dataTables.bootstrap4.min.css'
            ),
            'scripts' => array(
                'plugins/datatables/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables/datatables.net-responsive/js/dataTables.responsive.min.js',
                'plugins/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
                'plugins/datatables/estacionamento.js',
            ),
            'precificacoes' => $this->core_model->get_all('precificacoes'),
        );


        $this->load->view('layout/header', $data);
        $this->load->view('precificacoes/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($precificacao_id = NULL) {


        if (!$precificacao_id) {

            //Cadastra

            $this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'required|min_length[4]|max_length[50]|is_unique[precificacoes.precificacao_categoria]');
            $this->form_validation->set_rules('precificacao_valor_hora', '', 'required');
            $this->form_validation->set_rules('precificacao_valor_mensalidade', '', 'required');
            $this->form_validation->set_rules('precificacao_numero_vagas', '', 'required|greater_than[0]|integer');

            if ($this->form_validation->run()) {

                $data = elements(
                        array(
                    'precificacao_categoria',
                    'precificacao_valor_hora',
                    'precificacao_valor_mensalidade',
                    'precificacao_numero_vagas',
                    'precificacao_ativa',
                        ), $this->input->post()
                );

                $data = $this->security->xss_clean($data);

                $this->core_model->insert('precificacoes', $data);

                redirect('precificacoes');
            } else {

                $data = array(
                    'titulo' => 'Cadastrar precificação',
                    'pagina_atual' => 'Cadastrar precificação',
                    'info_pagina_atual' => 'Chegou a hora de cadastrar um nova precificação',
                    'icone_pagina' => 'ik-dollar-sign',
                    'valor_btn' => 'Cadastrar',
                    'scripts' => array(
                        'js/Mask/jquery.mask.min.js',
                        'js/Mask/custom.js',
                    ),
                );

                /* Erro de validação */
                $this->load->view('layout/header', $data);
                $this->load->view('precificacoes/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {

                $this->session->set_flashdata('error', 'Precificação não encontrada');
                redirect('precificacoes');
            } else {

                $this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'required|min_length[4]|max_length[50]|callback_check_precificacao_categoria');
                $this->form_validation->set_rules('precificacao_valor_hora', '', 'required');
                $this->form_validation->set_rules('precificacao_valor_mensalidade', '', 'required');
                $this->form_validation->set_rules('precificacao_numero_vagas', '', 'required|greater_than[0]|integer');

                if ($this->form_validation->run()) {


                    $data = elements(
                            array(
                        'precificacao_categoria',
                        'precificacao_valor_hora',
                        'precificacao_valor_mensalidade',
                        'precificacao_numero_vagas',
                        'precificacao_ativa',
                            ), $this->input->post()
                    );

                    $data = $this->security->xss_clean($data);

                    $this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));

                    redirect('precificacoes');
                } else {

                    $data = array(
                        'titulo' => 'Atualizar precificação',
                        'pagina_atual' => 'Atualizar precificação',
                        'info_pagina_atual' => 'Chegou a hora de atualizar uma precificação',
                        'icone_pagina' => 'ik-dollar-sign',
                        'scripts' => array(
                            'js/Mask/jquery.mask.min.js',
                            'js/Mask/custom.js',
                        ),
                        'valor_btn' => 'Atualizar',
                        'precificacao' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
                    );

                    /* Erro de validação */
                    $this->load->view('layout/header', $data);
                    $this->load->view('precificacoes/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_precificacao_categoria($precificacao_categoria) {

        $precificacao_id = $this->input->post('precificacao_id');

        if ($this->core_model->get_by_id('precificacoes', array('precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=' => $precificacao_id))) {

            $this->form_validation->set_message('check_precificacao_categoria', 'Essa categoria já existe');

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($precificacao_id = NULL) {

        if (!$precificacao_id || !$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {

            $this->session->set_flashdata('error', 'Precificação não encontrada');
            redirect('precificacoes');
        } else {

            $this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));

            redirect('precificacoes');
        }
    }

}
