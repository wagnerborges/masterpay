<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
	
	public function transacoes()
	{
		$this->session_verifier();
		$this->load->model('transacao_model','transacao');
		$usuario = $this->session->userdata('usuario_logado');
		
		$this->load->library('pagination');
		$config['base_url'] = base_url().'menu/transacoes';
		$config['uri_segment'] = 3;
		$config['per_page']	   = 8;

		//pagination style
		$config['first_link'] = '|<<';
		$config['prev_link'] = '<';
		$config['next_link'] = '>';
		$config['last_link'] = '>>|';


		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$page = $this->uri->segment(3,0);

		$dados['transacoes'] = $this->transacao->transacoes($usuario,$config['per_page'],$page)['transacoes']->result();
		$config['total_rows'] = $this->transacao->getTotalRows();

		$this->pagination->initialize($config);
		
		$dados['pagination'] = $this->pagination->create_links();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/transacoes_consulta',$dados);
        
        $this->load->view('includes/footer');
	}

	public function transacoesIntervalo()
	{
		$this->session_verifier();
		$this->load->model('transacao_model','transacao');
		$usuario = $this->session->userdata('usuario_logado');
		
		$dtInicio = $this->input->post('datainicio');
		$dtFim = $this->input->post('datafim');

		$this->load->library('pagination');
		$config['base_url'] = base_url().'menu/transacoes';
		$config['uri_segment'] = 3;
		$config['per_page']	   = 8;

		//pagination style
		$config['first_link'] = '|<<';
		$config['prev_link'] = '<';
		$config['next_link'] = '>';
		$config['last_link'] = '>>|';


		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$page = $this->uri->segment(3,0);

		$dados['transacoes'] = $this->transacao->transacoesIntervalo($usuario,$config['per_page'],$page,$dtInicio,$dtFim)['transacoes']->result();
		$config['total_rows'] = $this->transacao->getTotalRows();

		$this->pagination->initialize($config);
		
		$dados['pagination'] = $this->pagination->create_links();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/transacoes_consulta',$dados);
        
        $this->load->view('includes/footer');
	}

    public function repasses() {
		$this->session_verifier();
		$this->load->model('transacao_model','transacao');
		$usuario = $this->session->userdata('usuario_logado');
		
		$this->load->library('pagination');
		$config['base_url'] = base_url().'menu/repasses';
		$config['uri_segment'] = 3;
		$config['per_page']	   = 8;

		//pagination style
		$config['first_link'] = '|<<';
		$config['prev_link'] = '<';
		$config['next_link'] = '>';
		$config['last_link'] = '>>|';


		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$page = $this->uri->segment(3,0);

		$dados['repasses'] = $this->transacao->repasses($usuario,$config['per_page'],$page)['repasses']->result();
		$config['total_rows'] = $this->transacao->getTotalRows();

		$this->pagination->initialize($config);
		
		$dados['pagination'] = $this->pagination->create_links();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/repasse_consulta',$dados);
        
        $this->load->view('includes/footer');

	}

	public function compensacao() {
		$this->session_verifier();
		
		$usuario = $this->session->userdata('usuario_logado');

		$this->db->select('c.id,c.status,c.dia_repasse,c.data_confirmacao, c.total_credito,c.total_debito,c.total_geral,e.comercial_name,c.valor_desconto');
		$this->db->join('tab_estabelecimento as e','c.merchant=e.merchant','inner');
		if($usuario['perfil']=='CLIENTE') {
			$this->db->where('e.id',$usuario['estabelecimento_id']);
		}
		$this->db->order_by('c.status', 'ASC');
		$this->db->order_by('c.data_confirmacao', 'DESC');
		$dados['contas'] = $this->db->get('tab_conta_corrente_transacao as c')->result();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/compensacao',$dados);
        
        $this->load->view('includes/footer');

	}


	public function bancos() {
		$this->session_verifier();

		$usuario = $this->session->userdata('usuario_logado');

		$this->session_verifier();
		$this->db->select('*');
		$dados['estabelecimentos'] = $this->db->get('tab_estabelecimento')->result();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/banco',$dados);
        
        $this->load->view('includes/footer');
	}

	public function aluguel() {
		$this->session_verifier();

		$usuario = $this->session->userdata('usuario_logado');

		$this->db->select('*');
		$this->db->where('estabelecimento_id', $usuario['estabelecimento_id']);
		$dados['equipamento'] = $this->db->get('tab_controle_aluguel_equipamento')->result();

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/dashboard_equipamento',$dados);
        
        $this->load->view('includes/footer');
	}

	public function taxas() {
		$this->session_verifier();

		$usuario = $this->session->userdata('usuario_logado');

		if($usuario['perfil']=='CLIENTE') {
			$this->db->select('*');
			$this->db->where('e.id',$usuario['estabelecimento_id']);
			$this->db->join('tab_estabelecimento as e', 'e.id=p.estabelecimento_id');
			$dados['taxas'] = $this->db->get('tab_estabelecimento_parametro as p')->result();
		} else {
			$this->db->select('*');
			$dados['taxas'] = $this->db->get('tab_estabelecimento_parametro')->result();
		}

		$this->load->view('includes/header');
		$this->load->view('includes/side_menu');
		$this->load->view('includes/top_menu');
		
        $this->load->view('admin/taxas',$dados);
        
        $this->load->view('includes/footer');

	}

	public function session_verifier() {
		if($this->session->userdata('usuario_logado')==false) {
			redirect('login');
		}
	}
}
