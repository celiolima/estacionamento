<?php

defined('BASEPATH') or exit('Ação não permitida');

class Mensalistas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }
    }

    public function index()
    {

        $data = array(
            'titulo' => 'Listando todos os mensalistas',
            'pagina_atual' => 'Mensalistas',
            'info_pagina_atual' => 'Listando todos os mensalistas cadastrados',
            'icone_pagina' => 'fas fa-users',
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
            'mensalistas' => $this->core_model->get_all('mensalistas'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('mensalistas/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($mensalista_id = NULL)
    {

        if (!$mensalista_id) {

            //Cadastra

            $this->form_validation->set_rules('mensalista_nome', '', 'required|min_length[4]|max_length[45]');

            $this->form_validation->set_rules('mensalista_sobrenome', '', 'required|min_length[4]|max_length[145]');
            $this->form_validation->set_rules('mensalista_data_nascimento', '', 'required');

            $mensalista_tipo = $this->input->post('mensalista_tipo');

            if ($mensalista_tipo == 1) {
                $this->form_validation->set_rules('mensalista_cpf', '', 'required|callback_check_documento_valido');
            } else {
                $this->form_validation->set_rules('mensalista_cnpj', '', 'required|callback_check_documento_valido');
            }


            $this->form_validation->set_rules('mensalista_rg_ie', '', 'trim|required|is_unique[mensalistas.mensalista_rg_ie]');


            $this->form_validation->set_rules('mensalista_email', '', 'required|valid_email|is_unique[mensalistas.mensalista_email]');
            $this->form_validation->set_rules('mensalista_telefone_fixo', '', 'is_unique[mensalistas.mensalista_telefone_fixo]');
            $this->form_validation->set_rules('mensalista_telefone_movel', '', 'is_unique[mensalistas.mensalista_telefone_movel]');
            $this->form_validation->set_rules('mensalista_cep', '', 'required');
            $this->form_validation->set_rules('mensalista_endereco', '', 'required|min_length[5]|max_length[155]');
            $this->form_validation->set_rules('mensalista_numero_endereco', '', 'required|max_length[20]');
            $this->form_validation->set_rules('mensalista_bairro', '', 'required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('mensalista_cidade', '', 'required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('mensalista_estado', '', 'required|max_length[2]');
            $this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia vencimento', 'required|exact_length[2]|greater_than[0]|less_than[32]|integer');


            if ($this->form_validation->run()) {



                $data = elements(
                    array(
                        'mensalista_tipo',
                        'mensalista_nome',
                        'mensalista_sobrenome',
                        'mensalista_data_nascimento',
                        'mensalista_cpf_cnpj',
                        'mensalista_rg_ie',
                        'mensalista_email',
                        'mensalista_telefone_fixo',
                        'mensalista_telefone_movel',
                        'mensalista_cep',
                        'mensalista_endereco',
                        'mensalista_numero_endereco',
                        'mensalista_bairro',
                        'mensalista_cidade',
                        'mensalista_estado',
                        'mensalista_complemento',
                        'mensalista_ativo',
                        'mensalista_dia_vencimento',
                        'mensalista_obs',
                    ),
                    $this->input->post()
                );

                if ($mensalista_tipo == 1) {

                    $data['mensalista_cpf_cnpj'] = $this->input->post('mensalista_cpf');
                } else {

                    $data['mensalista_cpf_cnpj'] = $this->input->post('mensalista_cnpj');
                }

                $data = $this->security->xss_clean($data);

                //echo '<pre>';
                //print_r($data);
                //exit();

                $this->core_model->insert('mensalistas', $data);

                redirect($this->router->fetch_class());
            } else {

                /* Erro de validação */

                $data = array(
                    'titulo' => 'Cadastrar mensalista',
                    'pagina_atual' => 'Cadastrar mensalista',
                    'info_pagina_atual' => 'Chegou a hora de cadastrar um novo mensalista',
                    'icone_pagina' => 'fas fa-user-plus',
                    'valor_btn' => 'Cadastrar',
                    'scripts' => array(
                        'js/Mask/jquery.mask.min.js',
                        'js/Mask/custom.js',
                        'js/Mask/mensalista.js'
                    ),
                );

                $this->load->view('layout/header', $data);
                $this->load->view('mensalistas/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza


            if (!$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {

                $this->session->set_flashdata('error', 'Mensalista não encontrado');
                redirect($this->router->fetch_class());
            } else {

                $this->form_validation->set_rules('mensalista_nome', '', 'required|min_length[4]|max_length[45]');
                $this->form_validation->set_rules('mensalista_sobrenome', '', 'required|min_length[4]|max_length[145]');
                $this->form_validation->set_rules('mensalista_data_nascimento', '', 'required');

                $mensalista_tipo = $this->input->post('mensalista_tipo');

                if ($mensalista_tipo == 1) {
                    $this->form_validation->set_rules('mensalista_cpf', '', 'required|callback_check_documento_valido');
                } else {
                    $this->form_validation->set_rules('mensalista_cnpj', '', 'required|callback_check_documento_valido');
                }

                $this->form_validation->set_rules('mensalista_rg_ie', '', 'required|callback_check_rg_ie');
                $this->form_validation->set_rules('mensalista_email', '', 'required|valid_email|callback_check_email');


                /* Trecho que verifica no banco apenas se foi inputado alguma coisa nos campos correspondentes */
                /* Tem que ser assim, pois o campo não é obrigatório. */
                /* Na opção de 'Cadatsrar' caso não seja inputado algo, será salvo o campo em branco e o callback retorna FALSE */
                $mensalista_telefone_fixo = $this->input->post('mensalista_telefone_fixo');
                $mensalista_telefone_movel = $this->input->post('mensalista_telefone_movel');

                if (!empty($mensalista_telefone_fixo)) {
                    $this->form_validation->set_rules('mensalista_telefone_fixo', '', 'callback_check_telefone_fixo');
                }

                if (!empty($mensalista_telefone_movel)) {
                    $this->form_validation->set_rules('mensalista_telefone_movel', '', 'callback_check_telefone_movel');
                }
                /* Fim */



                $this->form_validation->set_rules('mensalista_cep', '', 'required');
                $this->form_validation->set_rules('mensalista_endereco', '', 'required|min_length[5]|max_length[155]');
                $this->form_validation->set_rules('mensalista_numero_endereco', '', 'required|max_length[20]');
                $this->form_validation->set_rules('mensalista_bairro', '', 'required|min_length[5]|max_length[45]');
                $this->form_validation->set_rules('mensalista_cidade', '', 'required|min_length[5]|max_length[45]');
                $this->form_validation->set_rules('mensalista_estado', '', 'required|max_length[2]');
                $this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia vencimento', 'required|exact_length[2]|greater_than[0]|less_than[32]|integer');


                if ($this->form_validation->run()) {

                    if (!$this->ion_auth->is_admin()) {

                        $this->session->set_flashdata('error', 'Você não pode editar mensalista');
                        redirect($this->router->fetch_class());
                    }

                    $data = elements(
                        array(
                            'mensalista_tipo',
                            'mensalista_nome',
                            'mensalista_sobrenome',
                            'mensalista_data_nascimento',
                            'mensalista_cpf_cnpj',
                            'mensalista_rg_ie',
                            'mensalista_email',
                            'mensalista_telefone_fixo',
                            'mensalista_telefone_movel',
                            'mensalista_cep',
                            'mensalista_endereco',
                            'mensalista_numero_endereco',
                            'mensalista_bairro',
                            'mensalista_cidade',
                            'mensalista_estado',
                            'mensalista_complemento',
                            'mensalista_ativo',
                            'mensalista_dia_vencimento',
                            'mensalista_obs',
                        ),
                        $this->input->post()
                    );

                    if ($mensalista_tipo == 1) {

                        $data['mensalista_cpf_cnpj'] = $this->input->post('mensalista_cpf');
                    } else {

                        $data['mensalista_cpf_cnpj'] = $this->input->post('mensalista_cnpj');
                    }

                    $data = $this->security->xss_clean($data);

                    //echo '<pre>';
                    //print_r($data);
                    //exit();

                    $this->core_model->update('mensalistas', $data, array('mensalista_id' => $mensalista_id));

                    redirect($this->router->fetch_class());
                } else {

                    /* Erro de validação */

                    $data = array(
                        'titulo' => 'Atualizar mensalista',
                        'pagina_atual' => 'Atualizar mensalista',
                        'info_pagina_atual' => 'Chegou a hora de atualizar um mensalista',
                        'icone_pagina' => 'fas fa-user-edit',
                        'valor_btn' => 'Atualizar',
                        'scripts' => array(
                            'js/Mask/jquery.mask.min.js',
                            'js/Mask/custom.js',
                            'js/Mask/mensalista.js'
                        ),
                        'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
                    );

                    //                    echo '<pre>';
                    //                    print_r($data['mensalista']);

                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalistas/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function del($mensalista_id = NULL)
    {

        if (!$this->ion_auth->is_admin()) {

            $this->session->set_flashdata('error', 'Você não pode excluir mensalista');
            redirect($this->router->fetch_class());
        }

        if (!$mensalista_id || !$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {

            $this->session->set_flashdata('error', 'Mensalista não encontrado');
            redirect($this->router->fetch_class());
        } else {

            $this->core_model->delete('mensalistas', array('mensalista_id' => $mensalista_id));
            redirect($this->router->fetch_class());
        }
    }

    public function check_documento_valido($mensalista_cpf_cnpj)
    {

        $mensalista_tipo = $this->input->post('mensalista_tipo');
        $mensalista_id = $this->input->post('mensalista_id');


        if ($mensalista_tipo == 1) {

            //Valida CPF

            if (!$mensalista_id) {

                //Valida cadastro
                //exit('Cdastrando');

                if ($this->core_model->get_by_id('mensalistas', array('mensalista_cpf_cnpj' => $mensalista_cpf_cnpj))) {

                    $this->form_validation->set_message('check_documento_valido', 'Esse CPF já exite');

                    return FALSE;
                }
            } else {

                //Valida atualização
                //exit('Atualizando');

                if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_cpf_cnpj' => $mensalista_cpf_cnpj))) {
                    $this->form_validation->set_message('check_documento_valido', 'Esse CPF já exite');
                    return FALSE;
                }
            }


            $mensalista_cpf_cnpj = str_pad(preg_replace('/[^0-9]/', '', $mensalista_cpf_cnpj), 11, '0', STR_PAD_LEFT);
            // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
            if (strlen($mensalista_cpf_cnpj) != 11 || $mensalista_cpf_cnpj == '00000000000' || $mensalista_cpf_cnpj == '11111111111' || $mensalista_cpf_cnpj == '22222222222' || $mensalista_cpf_cnpj == '33333333333' || $mensalista_cpf_cnpj == '44444444444' || $mensalista_cpf_cnpj == '55555555555' || $mensalista_cpf_cnpj == '66666666666' || $mensalista_cpf_cnpj == '77777777777' || $mensalista_cpf_cnpj == '88888888888' || $mensalista_cpf_cnpj == '99999999999') {

                $this->form_validation->set_message('check_documento_valido', 'Digite um CPF válido');
                return FALSE;
            } else {
                // Calcula os números para verificar se o CPF é verdadeiro
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $mensalista_cpf_cnpj[$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($mensalista_cpf_cnpj[$c] != $d) {
                        $this->form_validation->set_message('check_documento_valido', 'Digite um CPF válido');
                        return FALSE;
                    }
                }
                return TRUE;
            }
        } else {
            //Valida CNPJ

            if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_cpf_cnpj' => $mensalista_cpf_cnpj))) {
                $this->form_validation->set_message('check_documento_valido', 'Esse CNPJ já existe');
                return FALSE;
            }

            // Elimina possivel mascara
            $mensalista_cpf_cnpj = preg_replace("/[^0-9]/", "", $mensalista_cpf_cnpj);
            $mensalista_cpf_cnpj = str_pad($mensalista_cpf_cnpj, 14, '0', STR_PAD_LEFT);


            // Verifica se o numero de digitos informados é igual a 11 
            if (strlen($mensalista_cpf_cnpj) != 14) {
                $this->form_validation->set_message('check_documento_valido', 'Digite um CNPJ válido');
                return false;
            }

            // Verifica se nenhuma das sequências invalidas abaixo 
            // foi digitada. Caso afirmativo, retorna falso
            else if (
                $mensalista_cpf_cnpj == '00000000000000' ||
                $mensalista_cpf_cnpj == '11111111111111' ||
                $mensalista_cpf_cnpj == '22222222222222' ||
                $mensalista_cpf_cnpj == '33333333333333' ||
                $mensalista_cpf_cnpj == '44444444444444' ||
                $mensalista_cpf_cnpj == '55555555555555' ||
                $mensalista_cpf_cnpj == '66666666666666' ||
                $mensalista_cpf_cnpj == '77777777777777' ||
                $mensalista_cpf_cnpj == '88888888888888' ||
                $mensalista_cpf_cnpj == '99999999999999'
            ) {
                $this->form_validation->set_message('check_documento_valido', 'Digite um CNPJ válido');
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

                    //$soma2 += ($mensalista_cpf_cnpj{$i} * $k);

                    $soma2 = intval($soma2) + ($mensalista_cpf_cnpj[$i] * $k);

                    if ($i < 12) {
                        $soma1 = intval($soma1) + ($mensalista_cpf_cnpj[$i] * $j);
                    }

                    $k--;
                    $j--;
                }

                $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
                $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

                if (!($mensalista_cpf_cnpj[12] == $digito1) and ($mensalista_cpf_cnpj[13] == $digito2)) {
                    $this->form_validation->set_message('check_documento_valido', 'Digite um CNPJ válido');
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    public function check_email($mensalista_email)
    {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_email' => $mensalista_email, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_email', 'Esse e-mail já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_telefone_fixo($mensalista_telefone_fixo)
    {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_telefone_fixo' => $mensalista_telefone_fixo, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_telefone_fixo', 'Esse telefone já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_telefone_movel($mensalista_telefone_movel)
    {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_telefone_movel' => $mensalista_telefone_movel, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_telefone_movel', 'Esse telefone já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_rg_ie($mensalista_rg_ie)
    {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_rg_ie' => $mensalista_rg_ie, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_rg_ie', 'Essa informação já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }
}
