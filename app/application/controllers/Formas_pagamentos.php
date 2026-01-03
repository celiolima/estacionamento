<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Formas_pagamentos extends CI_Controller {

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

        $data = array(
            'titulo' => 'Listando as formas de pagamentos',
            'info_pagina_atual' => 'Listando as formas de pagamentos',
            'pagina_atual' => 'Formas de pagamentos',
            'icone_pagina' => 'fas fa-money-bill-alt',
            'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('formas_pagamentos/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($forma_pagamento_id = NULL) {

        if (!$forma_pagamento_id) {

            //Cadastra

            $this->form_validation->set_rules('forma_pagamento_nome', '', 'required|min_length[5]|max_length[30]|callback_check_forma_pagamento_nome');

            if ($this->form_validation->run()) {

                $data = elements(
                        array(
                    'forma_pagamento_nome',
                    'forma_pagamento_ativa'), $this->input->post()
                );

                $data = $this->security->xss_clean($data);

                $this->core_model->insert('formas_pagamentos', $data);

                redirect('pagamentos');
            } else {

                /* Erro de validação */
                $data = array(
                    'titulo' => 'Cadastrar forma de pagamento',
                    'info_pagina_atual' => 'Cadastre uma forma de pagamento',
                    'pagina_atual' => 'Cadastrar',
                    'icone_pagina' => 'fas fa-money-bill-alt',
                    'valor_btn' => 'Cadastrar',
                );


                $this->load->view('layout/header', $data);
                $this->load->view('formas_pagamentos/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))) {

                $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
                redirect('pagamentos');
            } else {

                $this->form_validation->set_rules('forma_pagamento_nome', '', 'required|min_length[5]|max_length[30]|callback_check_forma_pagamento_nome');

                if ($this->form_validation->run()) {


                    $data = elements(
                            array(
                        'forma_pagamento_nome',
                        'forma_pagamento_ativa'), $this->input->post()
                    );

                    $data = $this->security->xss_clean($data);

                    $this->core_model->update('formas_pagamentos', $data, array('forma_pagamento_id' => $forma_pagamento_id));

                    redirect('pagamentos');
                } else {

                    /* Erro de validação */
                    $data = array(
                        'titulo' => 'Atualizar forma de pagamento',
                        'info_pagina_atual' => 'Atualize uma forma de pagamento',
                        'pagina_atual' => 'Atualizar',
                        'icone_pagina' => 'fas fa-money-bill-alt',
                        'valor_btn' => 'Atualizar',
                        'forma_pagamento' => $this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id)),
                    );


                    $this->load->view('layout/header', $data);
                    $this->load->view('formas_pagamentos/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_forma_pagamento_nome($forma_pagamento_nome) {

        $forma_pagamento_id = $this->input->post('forma_pagamento_id');

        if ($this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_nome' => $forma_pagamento_nome, 'forma_pagamento_id !=' => $forma_pagamento_id))) {

            $this->form_validation->set_message('check_forma_pagamento_nome', 'Esse nome já existe. Ele deve ser único');

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($forma_pagamento_id = NULL) {

        if (!$forma_pagamento_id || !$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))) {
            $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
            redirect('pagamentos');
        } else {

            $this->core_model->delete('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id));
            redirect('pagamentos');
        }
    }

}
