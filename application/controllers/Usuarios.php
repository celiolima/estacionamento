<?php

defined('BASEPATH') or exit('Ação não permitida');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }
    }

    public function index() {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
            redirect('home');
        }

        $data = array(
            'titulo' => 'Listando os usuários cadastrados',
            'pagina_atual' => 'Usuários',
            'info_pagina_atual' => 'Listando todos os usuários cadastrados',
            'icone_pagina' => 'ik-users',
            'usuarios' => $this->ion_auth->users()->result(),
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
        );

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($user_id = NULL) {


        if (!$user_id) {

            //Cadastra

            if (!$this->ion_auth->is_admin()) {
                $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
                redirect('home');
            }

            $this->form_validation->set_rules('first_name', '', 'required|alpha|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('last_name', '', 'required|alpha|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('email', '', 'required|valid_email|min_length[4]|max_length[50]|callback_check_email|is_unique[users.email]');
            $this->form_validation->set_rules('username', '', 'required|min_length[5]|max_length[100]|callback_check_username|is_unique[users.username]');
            $this->form_validation->set_rules('password', '', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('confirma_senha', '', 'required|matches[password]');


            if ($this->form_validation->run()) {


                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');


                $dados_adicionais = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'active' => $this->input->post('active'), // Não esquecer de comentar a linha 853 do ion_auth_model
                );

                $group = array($this->input->post('perfil')); //Tem que ser array

                $dados_adicionais = $this->security->xss_clean($dados_adicionais);

                if ($this->ion_auth->register($username, $password, $email, $dados_adicionais, $group)) {

                    $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
                } else {
                    $this->session->set_flashdata('error', 'Erro ao salvar os dados');
                }
                redirect('usuarios');
            } else {

                $data = array(
                    'titulo' => 'Cadastrar usuário',
                    'pagina_atual' => 'Cadastrar usuário',
                    'info_pagina_atual' => 'Chegou a hora de cadastrar um novo usuário',
                    'icone_pagina' => 'ik-user-plus',
                    'valor_btn' => 'Cadastrar',
                );

                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->ion_auth->user($user_id)->row()) {
                $this->session->set_flashdata('error', 'Usuário não encontrado');
                redirect('usuarios');
            } else {

                if ($this->session->userdata('user_id') != $user_id && !$this->ion_auth->is_admin()) {
                    $this->session->set_flashdata('info', 'Você não pode alterar um usuário diferente do seu!');
                    redirect('home');
                }

                $perfil_atual = $this->ion_auth->get_users_groups($user_id)->row();

                $this->form_validation->set_rules('first_name', '', 'required|alpha|min_length[4]|max_length[50]');
                $this->form_validation->set_rules('last_name', '', 'required|alpha|min_length[4]|max_length[50]');
                $this->form_validation->set_rules('email', '', 'required|valid_email|min_length[4]|max_length[50]|callback_check_email');
                $this->form_validation->set_rules('username', '', 'required|min_length[5]|max_length[100]|callback_check_username');
                $this->form_validation->set_rules('password', '', 'min_length[4]|max_length[254]');
                $this->form_validation->set_rules('confirma_senha', '', 'matches[password]');


                if ($this->form_validation->run()) {


                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'email' => $this->input->post('email'),
                        'username' => $this->input->post('username'),
                        'password' => $this->input->post('password'), //Não alterar o 'name' do input... Deixar como 'password'
                        'active' => $this->input->post('active'),
                    );


                    /* Remove do array o campo active, caso o mesmo não tenha sido passado 
                     * Nesse caso, se não for admin
                     */
                    if (!$this->ion_auth->is_admin()) {
                        unset($data['active']);
                    }


                    $password = $this->input->post('password'); ///VER ATUALIZAÇÃO DE SENHA

                    /* Remove do array o campo senha, caso a mesma não tenha sido passada */
                    if (!$password) {
                        unset($data['password']);
                    }

                    /* Limpa o número de tentativas de login, caso o 'active' seja == 1 */
                    if ($this->input->post('active') == 1) {
                        $this->ion_auth->clear_login_attempts($this->input->post('email'));
                    }

                    $data = $this->security->xss_clean($data);


                    if ($this->ion_auth->update($user_id, $data)) {

                        $perfil_post = $this->input->post('perfil');

                        /* Se for passado o perfil no post, passa para a regra seguinte */
                        if ($perfil_post) {

                            /* Se for diferente, atualiza */
                            if ($perfil_atual->id != $perfil_post) {

                                $this->ion_auth->remove_from_group($perfil_atual->id, $user_id);
                                $this->ion_auth->add_to_group($perfil_post, $user_id);
                            }
                        }

                        $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
                    } else {

                        $this->session->set_flashdata('error', 'Erro ao salvar os dados');
                    }

                    if ($this->ion_auth->is_admin()) {
                        redirect('usuarios');
                    } else {
                        redirect('home');
                    }
                } else {

                    $data = array(
                        'titulo' => 'Atualizar usuário',
                        'pagina_atual' => 'Atualizar usuário',
                        'info_pagina_atual' => 'Chegou a hora de atualizar o usuário',
                        'icone_pagina' => 'ik-user-check',
                        'valor_btn' => 'Atualizar',
                        'user' => $this->ion_auth->user($user_id)->row(),
                        'perfil' => $this->ion_auth->get_users_groups($user_id)->row(),
                    );

                    /* Erro de validação form_validation */
                    $this->load->view('layout/header', $data);
                    $this->load->view('usuarios/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function del($user_id = NULL) {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }


        if (!$user_id || !$this->ion_auth->user($user_id)->row()) {
            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }

        if ($this->ion_auth->is_admin($user_id)) {
            $this->session->set_flashdata('error', 'Você não pode excluir o administrador');
            redirect('usuarios');
        }

        if ($this->ion_auth->delete_user($user_id)) {
            $this->session->set_flashdata('sucesso', 'Usuário excluído com sucesso!');
        } else {

            $this->session->set_flashdata('error', 'Erro ao excluir o usuário');
        }

        redirect('usuarios');
    }

    public function check_email($email) {

        $user_id = $this->input->post('user_id');

        if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $user_id))) {

            $this->form_validation->set_message('check_email', 'Esse e-mail já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_username($username) {

        $user_id = $this->input->post('user_id');

        if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $user_id))) {

            $this->form_validation->set_message('check_username', 'Esse usuário já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }

}
