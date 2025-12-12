<?php

defined('BASEPATH') or exit('Ação não permitida');

class Login extends CI_Controller
{

    public function index()
    {

        $data = array(
            'titulo' => 'Login'
        );

        $this->load->view('login/index', $data);
    }

    public function auth()
    {

        $email = $this->security->xss_clean($this->input->post('email'));
        $senha = $this->security->xss_clean($this->input->post('senha'));
        $remember = FALSE;

        if ($this->ion_auth->login($email, $senha, $remember)) {
            redirect('home');
        } else {
            $this->session->set_flashdata('error', 'E-mail e/ou senha incorretos');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect('login');
    }
}
