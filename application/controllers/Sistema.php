<?php

defined('BASEPATH') or exit('Ação não permitida');

class Sistema extends CI_Controller
{

    public function __construct()
    {
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

    public function index()
    {

        $dataInfo = array(
            'titulo' => 'Sistema',
            'pagina_atual' => 'Sistema',
            'info_pagina_atual' => 'Chegou a hora de atualizar as informações do sistema',
            'icone_pagina' => 'ik-settings',
            'scripts' => array(
                'js/Mask/jquery.mask.min.js',
                'js/Mask/custom.js',
            ),
            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
        );


        //        echo '<pre>';
        //        print_r($data['sistema']);
        //        exit();


        $this->form_validation->set_rules('sistema_razao_social', '', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', '', 'required|min_length[5]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', 'CNPJ', 'required|exact_length[18]|callback_valida_cnpj');
        $this->form_validation->set_rules('sistema_ie', 'I.E.', 'required|exact_length[12]');
        $this->form_validation->set_rules('sistema_telefone_fixo', '', 'required|exact_length[14]');
        $this->form_validation->set_rules('sistema_telefone_movel', '', 'required|exact_length[14]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', '', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_cidade', '', 'required|min_length[4]|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_email', '', 'required|valid_email');
        $this->form_validation->set_rules('sistema_site_url', 'URL', 'required|min_length[10]|max_length[100]');
        //        $this->form_validation->set_rules('sistema_num_vagas_pequeno', '', 'required|greater_than[0]|integer');
        //        $this->form_validation->set_rules('sistema_num_vagas_grande', '', 'required|greater_than[0]|integer');


        $this->form_validation->set_rules('sistema_txt_ordem_servico', '', 'required');



        if ($this->form_validation->run()) {

            $data = elements(
                array(
                    'sistema_razao_social',
                    'sistema_nome_fantasia',
                    'sistema_cnpj',
                    'sistema_ie',
                    'sistema_telefone_fixo',
                    'sistema_telefone_movel',
                    'sistema_cep',
                    'sistema_endereco',
                    'sistema_cidade',
                    'sistema_estado',
                    'sistema_email',
                    'sistema_site_url',
                    //                'sistema_num_vagas_pequeno',
                    //                'sistema_num_vagas_grande',
                    'sistema_txt_ordem_servico',
                ),
                $this->input->post()
            );

            $data = $this->security->xss_clean($data);


            $this->core_model->update('sistema', $data, array('sistema_id' => 1));

            $this->load->view('layout/header', $dataInfo);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
            //redirect('sistema/index');
        } else {

            /* Erro de validações form_validation */
            $this->load->view('layout/header', $dataInfo);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
        }
    }

    public function valida_cnpj($cnpj)
    {

        // Verifica se um número foi informado
        if (empty($cnpj)) {
            $this->form_validation->set_message('valida_cnpj', 'Por favor digite um CNPJ válido');
            return false;
        }

        // Elimina possivel mascara
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);


        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cnpj) != 14) {
            $this->form_validation->set_message('valida_cnpj', 'Por favor digite um CNPJ válido');
            return false;
        }

        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if (
            $cnpj == '00000000000000' ||
            $cnpj == '11111111111111' ||
            $cnpj == '22222222222222' ||
            $cnpj == '33333333333333' ||
            $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' ||
            $cnpj == '66666666666666' ||
            $cnpj == '77777777777777' ||
            $cnpj == '88888888888888' ||
            $cnpj == '99999999999999'
        ) {
            $this->form_validation->set_message('valida_cnpj', 'Por favor digite um CNPJ válido');
            return false;

            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            $j = 5;
            $k = 6;
            $soma1 = "";
            $soma2 = "";

            for ($i = 0; $i < 13; $i++) {

                $j = $j == 1 ? 9 : $j;
                $k = $k == 1 ? 9 : $k;

                //$soma2 += ($cnpj{$i} * $k);

                $soma2 = intval($soma2) + ($cnpj[$i] * $k);

                if ($i < 12) {
                    $soma1 = intval($soma1) + ($cnpj[$i] * $j);
                }

                $k--;
                $j--;
            }

            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

            if (!($cnpj[12] == $digito1) and ($cnpj[13] == $digito2)) {
                $this->form_validation->set_message('valida_cnpj', 'Por favor digite um CNPJ válido');
                return false;
            } else {
                return true;
            }
        }
    }
}
