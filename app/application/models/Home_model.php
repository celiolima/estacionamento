<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Home_model extends CI_Model {



    public function get_total_vagas() {

        $this->db->select('SUM(precificacao_numero_vagas) as total');
        $this->db->where('precificacao_ativa', 1);

        return $this->db->get('precificacoes')->row();
    }

    public function get_total_receber() {


        $this->db->select('FORMAT(SUM(mensalidade_valor_mensalidade),2) as total');
        //$this->db->where('mensalidade_status', 0);

        return $this->db->get('mensalidades')->row();
    }

    public function get_total_avulsos() {


        $this->db->select('FORMAT(SUM(estacionar_valor_devido),2) as total');
        //$this->db->where('mensalidade_status', 0);

        return $this->db->get('estacionar')->row();
    }

    public function count_all($tabela = NULL, $condition = NULL) {

        $this->db->from($tabela);

        if ($condition) {
            $this->db->where($condition);
        }
        return $this->db->count_all_results();
    }

    public function get_mensalidades_vencidas() {

        $this->db->where('mensalidade_data_vencimento <', date('Y-m-d'));
        $this->db->where('mensalidade_status', 0);

        return $this->db->get('mensalidades')->result();
    }

}
