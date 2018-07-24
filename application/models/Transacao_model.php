<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transacao_model extends CI_Model {

    public $lastQuery = '';

    public function transacoes($usuario,$limite,$start) {
        if($usuario['perfil']=='CLIENTE') {
            $this->db->select('t.*');
			$this->db->where('e.id',$usuario['estabelecimento_id']);
			$this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
            $this->db->order_by('t.payment_date','DESC');
            $this->db->limit($limite,$start);
            $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
            $this->lastQuery = $this->db->last_query();
		} else {
			$this->db->select('t.*, e.comercial_name');
			$this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
            $this->db->order_by('t.payment_date','DESC');
            $this->db->limit($limite,$start);
            $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
            $this->lastQuery = $this->db->last_query();
        }
        return $dados;
    }

    public function transacoes_hoje($usuario) {
        
        //$datahoje = date('d/m/Y');

        if($usuario['perfil']=='CLIENTE') {
            $this->db->select('t.*');
            $this->db->where('e.id',$usuario['estabelecimento_id']);
            //$this->db->where('date_format(t.payment_date,'."'%d/%m/%Y'".')',$datahoje);
            $this->db->where('date_format(t.payment_date,'."'%Y%m%d'".') = date_format(CURRENT_DATE,'."'%Y%m%d'".')');
            $this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
            $this->db->order_by('t.payment_date','DESC');
            $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
		} else {
            $this->db->select('t.*, e.comercial_name');
            $this->db->where('date_format(t.payment_date,'."'%Y%m%d'".') = date_format(CURRENT_DATE,'."'%Y%m%d'".')');
			$this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
            $this->db->order_by('t.payment_date','DESC');
            $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
        }
        return $dados;
    }

    public function transacoesIntervalo($usuario,$limite,$start,$dtInicio,$dtFim,$textSearch="") {
        if($usuario['perfil']=='CLIENTE') {
            $this->db->select('t.*');
            $this->db->where('e.id',$usuario['estabelecimento_id']);
            $this->db->where('date_format(t.payment_date,'."'%d/%m/%Y'".') >=',$dtInicio);
            $this->db->where('date_format(t.payment_date,'."'%d/%m/%Y'".') <=',$dtFim);
           
			$this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
            $this->db->order_by('t.payment_date','DESC');
            $this->db->limit($limite,$start);
            $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
            $this->lastQuery = $this->db->last_query();
		} else {
            if($dtInicio == "" && $dtFim == "") {
                $this->db->select('t.*, e.comercial_name');
                $this->db->like('product_name', $textSearch);
                $this->db->or_like('brand', $textSearch);
                $this->db->or_like('FORMAT(value, 2, \'de_DE\')', $textSearch);
                $this->db->or_like('FORMAT(valor_liquido, 2, \'de_DE\')', $textSearch);
                $this->db->or_like('authorization_number', $textSearch);
                $this->db->or_like('comercial_name', $textSearch);
                $this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
                $this->db->order_by('t.payment_date','DESC');
                $this->db->limit($limite,$start);
                $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
                $this->lastQuery = $this->db->last_query();
            } else {
                $this->db->select('t.*, e.comercial_name');
                $this->db->group_start();
                    $this->db->like('product_name', $textSearch);
                    $this->db->or_like('brand', $textSearch);
                    $this->db->or_like('FORMAT(value, 2, \'de_DE\')', $textSearch);
                    $this->db->or_like('FORMAT(valor_liquido, 2, \'de_DE\')', $textSearch);
                    $this->db->or_like('authorization_number', $textSearch);
                    $this->db->or_like('comercial_name', $textSearch);
                $this->db->group_end();
                $this->db->group_start();
                    $this->db->where('date_format(t.payment_date,'."'%d/%m/%Y'".') >=',$dtInicio);
                    $this->db->where('date_format(t.payment_date,'."'%d/%m/%Y'".') <=',$dtFim);
                $this->db->group_end();
                $this->db->join('tab_estabelecimento as e','t.estabelecimento_id=e.id','inner');
                $this->db->order_by('t.payment_date','DESC');
                $this->db->limit($limite,$start);
                $dados['transacoes'] = $this->db->get('tab_transacao_processada as t');
                $this->lastQuery = $this->db->last_query();
            }
        }
        return $dados;
    }

    public function getTotalRows() {
        $sql = explode('LIMIT', $this->lastQuery);
        $query = $this->db->query($sql[0]);
        $result = $query->result();
        return count($result);
    }

    public function repasses($usuario,$limite,$start) {

        if($usuario['perfil']=='CLIENTE') {
			$this->db->select('r.id,r.valor_transacao,r.liquido_cliente,r.data_transacao,r.data_repasse,r.status');
            $this->db->where('e.id',$usuario['estabelecimento_id']);
            $this->db->join('tab_estabelecimento as e', 'e.id=r.estabelecimento_id');
            $this->db->order_by('r.data_repasse','DESC');
            $this->db->limit($limite,$start);
            $dados['repasses'] = $this->db->get('tab_transacao_repasse as r');
            $this->lastQuery = $this->db->last_query();
		} else {
            $this->db->select('*');
            $this->db->order_by('r.data_repasse','DESC');
            $this->db->limit($limite,$start);
            $dados['repasses'] = $this->db->get('tab_transacao_repasse as r');
            $this->lastQuery = $this->db->last_query();
        }
        return $dados;
    }

    public function repassesIntervalo($usuario,$limite,$start,$dtInicio,$dtFim,$textSearch="") {

        if($usuario['perfil']=='CLIENTE') {
            $this->db->select('r.id,r.valor_transacao,r.liquido_cliente,r.data_transacao,r.data_repasse,r.status');
            $this->db->where('e.id',$usuario['estabelecimento_id']);
            $this->db->join('tab_estabelecimento as e', 'e.id=r.estabelecimento_id');
            $this->db->order_by('r.data_repasse','DESC');
            $this->db->limit($limite,$start);
            $dados['repasses'] = $this->db->get('tab_transacao_repasse as r');
            $this->lastQuery = $this->db->last_query();
        } else {
            if($dtInicio == "" && $dtFim == "") {
                $this->db->select('*');
                $this->db->like('FORMAT(valor_transacao, 2, \'de_DE\')', $textSearch);
                $this->db->or_like('FORMAT(liquido_cliente, 2, \'de_DE\')', $textSearch);
                $this->db->or_like('status', $textSearch);
                $this->db->order_by('r.data_repasse','DESC');
                $this->db->limit($limite,$start);
                $dados['repasses'] = $this->db->get('tab_transacao_repasse as r');
                $this->lastQuery = $this->db->last_query();
            } else {
                $this->db->select('*');
                $this->db->group_start();
                    $this->db->like('FORMAT(valor_transacao, 2, \'de_DE\')', $textSearch);
                    $this->db->or_like('FORMAT(liquido_cliente, 2, \'de_DE\')', $textSearch);
                    $this->db->or_like('status', $textSearch);
                $this->db->group_end();
                $this->db->group_start();
                    $this->db->or_group_start();
                        $this->db->where('date_format(data_transacao,'."'%d/%m/%Y'".') >=',$dtInicio);
                        $this->db->where('date_format(data_transacao,'."'%d/%m/%Y'".') <=',$dtFim);
                    $this->db->group_end();
                    $this->db->or_group_start();
                        $this->db->where('date_format(data_repasse,'."'%d/%m/%Y'".') >=',$dtInicio);
                        $this->db->where('date_format(data_repasse,'."'%d/%m/%Y'".') <=',$dtFim);
                    $this->db->group_end();
                $this->db->group_end();
                $this->db->order_by('r.data_repasse','DESC');
                $this->db->limit($limite,$start);
                $dados['repasses'] = $this->db->get('tab_transacao_repasse as r');
                $this->lastQuery = $this->db->last_query();
            }
        }
        return $dados;
    }
}
