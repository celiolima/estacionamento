<?php

defined('BASEPATH') or exit('Ação não permitida');

class Estacionar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('error', 'Sua sessão expirou!');
            redirect('login');
        }


        //        if (!$this->ion_auth->is_admin()) {
        //            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
        //            redirect('home');
        //        }

        $this->load->model('core_model');
        $this->load->model('estacionar_model');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index()
    {

        //        if (!$this->ion_auth->is_admin()) {
        //            $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
        //            redirect('home');
        //        }

        $data = array(
            'titulo' => 'Listando todas as ordens de estacionamento',
            'info_pagina_atual' => 'Listando todas as ordens de estacionamento',
            'pagina_atual' => 'Estacionar',
            'icone_pagina' => 'fas fa-parking',
            'styles' => array(
                'plugins/datatables/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
                'dist/css/estacionar.css'
            ),
            'scripts' => array(
                'plugins/datatables/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables/datatables.net-responsive/js/dataTables.responsive.min.js',
                'plugins/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
                'plugins/datatables/estacionamento.js',
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
        );

        //echo '<pre>';
        //print_r($data['vagas_ocupadas_moto']);
        //exit();

        $this->load->view('layout/header', $data);
        $this->load->view('estacionar/listar');
        $this->load->view('layout/footer');
    }

    public function modulo($estacionar_id = NULL)
    {

        if (!$estacionar_id) {

            //Cadastra

            $this->form_validation->set_rules('estacionar_precificacao_id', '', 'required');
            $this->form_validation->set_rules('estacionar_numero_vaga', '', 'required|greater_than[0]|integer|callback_check_vaga_ocupada|callback_check_range_vagas_categoria');
            $this->form_validation->set_rules('estacionar_placa_veiculo', 'Placa', 'required|exact_length[8]|callback_check_placa_status_aberta');
            $this->form_validation->set_rules('estacionar_marca_veiculo', '', 'required');
            $this->form_validation->set_rules('estacionar_modelo_veiculo', '', 'required');


            if ($this->form_validation->run()) {


                $data = elements(
                    array(
                        'estacionar_valor_hora',
                        'estacionar_numero_vaga',
                        'estacionar_placa_veiculo',
                        'estacionar_marca_veiculo',
                        'estacionar_modelo_veiculo',
                    ),
                    $this->input->post()
                );

                $data['estacionar_precificacao_id'] = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));
                $data['estacionar_status'] = 0; // Ao cadastrar a ordem, a coluna estacionar_status recebe 0

                $data = $this->security->xss_clean($data);

                $this->core_model->insert('estacionar', $data, TRUE); //TRUE hibilita a captura do último ID inserido no banco (funcão insert do core_model)

                /* Recupera da sessão o id da última ordem inserida no banco */
                $estacionar_id = $this->session->userdata('last_id');

                redirect('estacionar/imprimir/' . $estacionar_id);
            } else {

                $data = array(
                    'titulo' => 'Cadastrar ordem de estacionamento',
                    'pagina_atual' => 'Cadastrar',
                    'info_pagina_atual' => 'Cadastrar ordem de estacionamento',
                    'icone_pagina' => 'fas fa-parking',
                    'valor_btn' => 'Cadastrar',
                    'texto_modal' => 'Tem certeza que deseja salvar a ordem? Não será possível alterá-la.',
                    'scripts' => array(
                        'js/Mask/jquery.mask.min.js',
                        'js/Mask/custom.js',
                        'js/Estacionar/custom.js',
                    ),
                    'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                );

                /* Erro validação */
                $this->load->view('layout/header', $data);
                $this->load->view('estacionar/modulo');
                $this->load->view('layout/footer');
            }
        } else {

            //Encerra

            if (!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {

                $this->session->set_flashdata('error', 'Dados não encontrados para atualização');
                redirect('estacionar');
            } else {

                $this->form_validation->set_rules('estacionar_placa_veiculo', '', 'required');


                $estacionar_tempo_decorrido = str_replace('.', '', $this->input->post('estacionar_tempo_decorrido'));

                if ($estacionar_tempo_decorrido > '015') {
                    $this->form_validation->set_rules('estacionar_forma_pagamento_id', '', 'required');
                }


                if ($this->form_validation->run()) {

                    $data = elements(
                        array(
                            'estacionar_valor_devido',
                            'estacionar_forma_pagamento_id',
                            'estacionar_tempo_decorrido',
                        ),
                        $this->input->post()
                    );


                    if ($estacionar_tempo_decorrido <= '015') {
                        $data['estacionar_forma_pagamento_id'] = 8; //Forma de pagamento Grátis
                    }

                    $data['estacionar_data_saida'] = date('Y-m-d H:i:s');
                    $data['estacionar_status'] = 1; //Ao Encerrar a ordem, a coluna 'estacionar_status' recebe o valor 1

                    $data = $this->security->xss_clean($data);

                    $this->core_model->update('estacionar', $data, array('estacionar_id' => $estacionar_id));
                    redirect('estacionar/imprimir/' . $estacionar_id);
                } else {

                    $data = array(
                        'titulo' => 'Atualizar ordem de estacionamento',
                        'info_pagina_atual' => 'Atualizar ordem de estacionamento',
                        'pagina_atual' => 'Atualizar',
                        'icone_pagina' => 'fas fa-parking',
                        'valor_btn' => 'Encerrar',
                        'texto_modal' => 'Tem certeza que deseja encerrar a ordem?',
                        'scripts' => array(
                            'js/Mask/jquery.mask.min.js',
                            'js/Mask/custom.js',
                            'js/Estacionar/custom.js',
                        ),
                        'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
                        'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                        'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    );

                    /* Erro validação */
                    $this->load->view('layout/header', $data);
                    $this->load->view('estacionar/modulo');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_range_vagas_categoria($numero_vaga)
    {

        $precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

        if ($precificacao_id) {

            $precificacao = $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id));

            if ($precificacao->precificacao_numero_vagas < $numero_vaga) {

                $this->form_validation->set_message('check_range_vagas_categoria', 'A vaga deve estar entre 1 e ' . $precificacao->precificacao_numero_vagas);

                return FALSE;
            } else {

                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_range_vagas_categoria', 'Escolha uma categoria');
            return FALSE;
        }
    }

    public function check_vaga_ocupada($estacionar_numero_vaga)
    {

        $estacionar_precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

        if ($this->core_model->get_by_id('estacionar', array('estacionar_numero_vaga' => $estacionar_numero_vaga, 'estacionar_status' => 0, 'estacionar_precificacao_id' => $estacionar_precificacao_id))) {

            $this->form_validation->set_message('check_vaga_ocupada', 'Essa vaga já está ocupada para essa categoria');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_placa_status_aberta($estacionar_placa_veiculo)
    {

        $estacionar_placa_veiculo = strtoupper($estacionar_placa_veiculo);

        if ($this->core_model->get_by_id('estacionar', array('estacionar_placa_veiculo' => $estacionar_placa_veiculo, 'estacionar_status' => 0))) {

            $this->form_validation->set_message('check_placa_status_aberta', 'Existe uma ordem aberta para essa placa');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function del($estacionar_id = NULL)
    {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir registros');
            redirect('estacionar');
        }

        if (!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {

            $this->session->set_flashdata('error', 'Ordem de estacionamento não encontrada');
            redirect('estacionar');
        } else {

            if ($this->core_model->get_by_id('estacionar', array('estacionar_status' => 0, 'estacionar_id' => $estacionar_id))) {

                $this->session->set_flashdata('error', 'Não é possível excluir uma ordem de estacionamento com o status "Open"');
                redirect('estacionar');
            } else {

                $this->core_model->delete('estacionar', array('estacionar_id' => $estacionar_id));
                redirect('estacionar');
            }
        }
    }

    public function imprimir($estacionar_id = NULL)
    {

        if (!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
            $this->session->set_flashdata('error', 'Ordem não encontrada');
            redirect('estacionar');
        } else {

            $data = array(
                'titulo' => 'Escolha uma das opções a seguir',
                'info_pagina_atual' => 'Escolha uma das opções a seguir',
                'pagina_atual' => 'Quer fazer o que?',
                'icone_pagina' => 'fas fa-question',
                'ordem' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('estacionar/imprimir');
            $this->load->view('layout/footer');
        }
    }

    public function pdf($estacionar_id = NULL)
    {


        if (!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
            $this->session->set_flashdata('error', 'Ordem não encontrada');
            redirect('estacionar');
        } else {

            $this->load->library('pdf');

            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));

            $ordem = $this->estacionar_model->get_by_id($estacionar_id);
            //            
            //            echo '<pre>';
            //            print_r($ordem_servico);
            //            exit();

            $file_name = 'Ordem - Placa_' . $ordem->estacionar_placa_veiculo;

            $html = '<html style="font-size:8px">';

            $html .= '<head>';

            $html .= '<title>' . $empresa->sistema_razao_social . '</title>';

            $html .= '</head>';

            $html .= '<body style="font-size:8px">';


            /* Dados empresa */
            $html .= '<h5 align = "center">
            ' . $empresa->sistema_nome_fantasia . '<br/>
            CNPJ: ' . $empresa->sistema_cnpj . '<br/>
            ' . $empresa->sistema_endereco . ' - ' . $empresa->sistema_numero . ' <br/>
            ' . $empresa->sistema_cep . '<br/>
            ' . $empresa->sistema_cidade . ' - ' . $empresa->sistema_estado . '<br/>
            ' . $empresa->sistema_telefone_fixo . '&nbsp;|&nbsp;' . $empresa->sistema_telefone_movel . '<br/>
            ' . $empresa->sistema_email . '<br/>
            </h5>';

            $html .= '<hr>';

            $dados_saida = '';

            if ($ordem->estacionar_status == 1) {
                $dados_saida .= '<strong>Data saída:</strong> ' . formata_data_banco_com_hora($ordem->estacionar_data_saida) . '<br/>'
                    . '<strong>Tempo decorrido (hh:mm):</strong> ' . $ordem->estacionar_tempo_decorrido . '<br/>'
                    . '<strong>Valor pago:</strong> ' . 'R$&nbsp;' . $ordem->estacionar_valor_devido . '<br/>'
                    . '<strong>Forma de pagamento:</strong> ' . $ordem->forma_pagamento . '<br/>';
            }


            /* Dados da ordem */
            $html .= '<p align = "right">Ordem N°: ' . $ordem->estacionar_id . '</p><br/>';
            $html .= '<p>'
                . '<strong>Placa veículo:</strong> ' . $ordem->estacionar_placa_veiculo . '<br/>'
                . '<strong>Marca veículo:</strong> ' . $ordem->estacionar_marca_veiculo . '<br/>'
                . '<strong>Modelo veículo:</strong> ' . $ordem->estacionar_modelo_veiculo . '<br/>'
                . '<strong>Categoria veículo:</strong> ' . $ordem->veiculo_categoria . '<br/>'
                . '<strong>Numero da vaga:</strong> ' . $ordem->estacionar_numero_vaga . '<br/>'
                . '<strong>Data entrada:</strong> ' . formata_data_banco_com_hora($ordem->estacionar_data_entrada) . '<br/>'
                . $dados_saida
                . '</p>';

            $html .= "<br>";

            $html .= '<hr>';

            $html .= '<h5 align = "center">
            ' . $empresa->sistema_nome_fantasia . '<br/>
            ' . $empresa->sistema_txt_ordem_servico . '<br/>
            ' . date('d/m/Y H:i:s') . '<br/>
            </h5>';

            $html .= '</body>';

            $html .= '</html>';

            /* False => abre no navegador; */
            /* True => Faz o download; */

            //            echo '<pre>';
            //            print_r($html);
            //            exit();

            $this->pdf->createPDF($html, $file_name, false);
        }
    }
}
