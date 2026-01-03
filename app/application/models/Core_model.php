<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Core_model extends CI_Model{

    public function get_all($table = NULL, $condition = NULL) {

        if ($table) {

            if (is_array($condition)) {
                $this->db->where($condition);
            }

            return $this->db->get($table)->result();
        } else {
            return false;
        }
    }

    public function get_by_id($table = NULL, $condition = NULL) {


        if ($table && is_array($condition)) {

            $this->db->where($condition);
            $this->db->limit(1);

            return $this->db->get($table)->row();
        } else {
            return false;
        }
    }

    public function insert($table = NULL, $data = NULL, $get_last_id = NULL) {

        if ($table && is_array($data)) {

            $this->db->insert($table, $data);

            /* Armazenando na sessão o último ID inserido */
            if ($get_last_id) {
                $this->session->set_userdata('last_id', $this->db->insert_id());
            }

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
            } else {

                $this->session->set_flashdata('error', 'Erro ao salvar os dados');
            }
        } else {
            return false;
        }
    }

    public function update($table = NULL, $data = NULL, $condition = NULL) {

        if ($table && is_array($data) && is_array($condition)) {

            if ($this->db->update($table, $data, $condition)) {

                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
            } else {
                $this->session->set_flashdata('error', 'Erro ao salvar os dados');
            }
        } else {
            return false;
        }
    }

    public function delete($table = NULL, $condition = NULL) {

        $this->db->db_debug = FALSE;

        if ($table && is_array($condition)) {

            $status = $this->db->delete($table, $condition);

            $error = $this->db->error();

            if (!$status) {

                foreach ($error as $code) {

                    if ($code == 1451) {
                        $this->session->set_flashdata('error', 'Esse registro não pode ser excluído, pois está atribuido a outra tabela.');
                    }
                }
            } else {
                $this->session->set_flashdata('sucesso', 'Registro excluído com sucesso');
            }

            $this->db->db_debug = TRUE;
        } else {
            return false;
        }
    }

}
