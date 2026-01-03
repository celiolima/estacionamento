<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Mensalidades extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }

        $this->load->model('mensalidades_model');
        $this->load->model('core_model');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
            redirect('home');
        }

        $data = array(
            'titulo' => 'Mensalidades cadastradas',
            'pagina_atual' => 'Mensalidades cadastradas',
            'info_pagina_atual' => 'Listando todas as mensalidades cadastradas',
            'icone_pagina' => 'fas fa-hand-holding-usd',
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
            'mensalidades' => $this->mensalidades_model->get_all(),
        );

//        echo '<pre>';
//        print_r($data['mensalidades']);
//        exit();


        $this->load->view('layout/header', $data);
        $this->load->view('mensalidades/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($mensalidade_id = NULL) {

        if (!$mensalidade_id) {

            //Cadastra

            $this->form_validation->set_rules('mensalidade_mensalista_id', '', 'required');
            $this->form_validation->set_rules('mensalidade_precificacao_id', '', 'required');
            $this->form_validation->set_rules('mensalidade_data_vencimento', '', 'required|callback_check_data_com_dia_vencimento|callback_check_existe_mensalidade|callback_check_data_valida');
            $this->form_validation->set_rules('mensalidade_status', '', 'required');


            if ($this->form_validation->run()) {

                $data = elements(
                        array(
                    'mensalidade_mensalista_id',
                    'mensalidade_precificacao_id',
                    'mensalidade_valor_mensalidade',
                    'mensalidade_mensalista_dia_vencimento',
                    'mensalidade_data_vencimento',
                    'mensalidade_status',
                        ), $this->input->post()
                );

                $data['mensalidade_mensalista_id'] = $this->input->post('mensalidade_mensalista_hidden_id');
                $data['mensalidade_precificacao_id'] = $this->input->post('mensalidade_precificacao_hidden_id');


                if ($data['mensalidade_status'] == 1) {
                    $data['mensalidade_data_pagamento'] = date('Y-m-d H:i:s');
                }

                $data = $this->security->xss_clean($data);


                $this->core_model->insert('mensalidades', $data);
                redirect($this->router->fetch_class());
            } else {

                $data = array(
                    'titulo' => 'Cadastrar mensalidade',
                    'pagina_atual' => 'Cadastrar mensalidade',
                    'icone_pagina' => 'fas fa-hand-holding-usd',
                    'texto_modal' => 'Tem certeza que deseja salvar a mensalidade? </br></br>Depois de salva, só será possível alterar a "Categoria" e a "Situação"',
                    'styles' => array(
                        'plugins/select2/dist/css/select2.min.css',
                    ),
                    'scripts' => array(
                        'js/Mask/jquery.mask.min.js',
                        'js/Mask/custom.js',
                        'plugins/select2/dist/js/select2.min.js',
                        'js/Mensalidades/custom.js',
                    ),
                    'valor_btn' => 'Cadastrar',
                    'precificacoes' => $this->core_model->get_all('precificacoes'), //Traz todas a precificações (ativas ou não) para carregar no dropdown e não der erro quando alguma for desativada
                    'mensalistas' => $this->core_model->get_all('mensalistas', array('mensalista_ativo' => 1)),
                );

                /* Erro de validação */
                $this->load->view('layout/header', $data);
                $this->load->view('mensalidades/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))) {

                $this->session->set_flashdata('error', 'Mensalidade não encontrada');
                redirect($this->router->fetch_class());
            } else {


                $this->form_validation->set_rules('mensalidade_precificacao_id', '', 'required');


                if ($this->form_validation->run()) {


                    $data = elements(
                            array(
                        'mensalidade_precificacao_id',
                        'mensalidade_valor_mensalidade',
                        'mensalidade_mensalista_dia_vencimento',
                        'mensalidade_status',
                            ), $this->input->post()
                    );

                    $data['mensalidade_mensalista_id'] = $this->input->post('mensalidade_mensalista_hidden_id');
                    $data['mensalidade_precificacao_id'] = $this->input->post('mensalidade_precificacao_hidden_id');


                    if ($data['mensalidade_status'] == 1) {
                        $data['mensalidade_data_pagamento'] = date('Y-m-d H:i:s');
                    }

                    $data = $this->security->xss_clean($data);

                    $this->core_model->update('mensalidades', $data, array('mensalidade_id' => $mensalidade_id));
                    redirect($this->router->fetch_class());
                } else {

                    $data = array(
                        'titulo' => 'Atualizar mensalidade',
                        'pagina_atual' => 'Atualizar mensalidade',
                        'icone_pagina' => 'fas fa-hand-holding-usd',
                        'texto_modal' => 'O dados estão corretos? </br></br>Depois de salva, não será possível alterar a mensalidade',
                        'styles' => array(
                            'plugins/select2/dist/css/select2.min.css',
                        ),
                        'scripts' => array(
                            'js/Mask/jquery.mask.min.js',
                            'js/Mask/custom.js',
                            'plugins/select2/dist/js/select2.min.js',
                            'js/Mensalidades/custom.js',
                        ),
                        'valor_btn' => 'Atualizar',
                        'precificacoes' => $this->core_model->get_all('precificacoes'), //Traz todas a precificações (ativas ou não) para carregar no dropdown e não der erro quando alguma for desativada
                        'mensalistas' => $this->core_model->get_all('mensalistas', array('mensalista_ativo' => 1)),
                        'mensalidade' => $this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id)),
                    );


                    /* Erro de validação */
                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalidades/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_data_com_dia_vencimento($mensalidade_data_vencimento) {

        if ($mensalidade_data_vencimento) {

            $mensalidade_data_vencimento = explode('-', $mensalidade_data_vencimento);

            $mensalidade_mensalista_dia_vencimento = $this->input->post('mensalidade_mensalista_dia_vencimento');

            if ($mensalidade_data_vencimento[2] != $mensalidade_mensalista_dia_vencimento) {
                $this->form_validation->set_message('check_data_com_dia_vencimento', 'Esse campo deve conter o mesmo dia que o "Melhor dia de vencimento"');
                return FALSE;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_data_com_dia_vencimento', 'Campo obrigatório');
            return FALSE;
        }
    }

    public function check_existe_mensalidade($mensalidade_data_vencimento) {

        /* Recupera o post */
        $mensalidade_mensalista_id = $this->input->post('mensalidade_mensalista_hidden_id');

        /* Verifica no banco se há mensalidade já cadastrada para o mensalista e coma data passsados no post */
        $mensalidade_user = $this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalidade_mensalista_id, 'mensalidade_data_vencimento' => $mensalidade_data_vencimento));

        if ($mensalidade_user) {

            /* Faz o explode da $mensalidade_data_vencimento do post */
            $mensalidade_data_vencimento_post = explode('-', $mensalidade_data_vencimento);


            /* Faz o explode da $mensalidade_data_vencimento vinda do banco */
            $mensalidade_data_vencimento_user = explode('-', $mensalidade_user->mensalidade_data_vencimento);



            if ($mensalidade_data_vencimento_post[0] == $mensalidade_data_vencimento_user[0] && $mensalidade_data_vencimento_post[1] == $mensalidade_data_vencimento_user[1]) {
                $this->form_validation->set_message('check_existe_mensalidade', 'Para o mensalista informado, já existe uma mensalidade para essa data');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function check_data_valida($mensalidade_data_vencimento) {

        $data_atual = strtotime(date('Y-m-d'));

        $mensalidade_data_vencimento = strtotime($mensalidade_data_vencimento);

        /* Se a data de vencimento for menor que a data atual */
        if ($data_atual >= $mensalidade_data_vencimento) {
            $this->form_validation->set_message('check_data_valida', 'A data de vencimento deve ser corrente ou futura');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($mensalidade_id = NULL) {

        if (!$mensalidade_id || !$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))) {

            $this->session->set_flashdata('error', 'Mensalidade não encontrada');
            redirect($this->router->fetch_class());
        }

        if ($this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id, 'mensalidade_status' => 0))) {
            $this->session->set_flashdata('error', 'Não é possível excluir uma mensalidade que ainda não foi paga');
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('mensalidades', array('mensalidade_id' => $mensalidade_id));
        redirect($this->router->fetch_class());
    }

}
