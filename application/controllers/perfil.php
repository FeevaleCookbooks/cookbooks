<?php


class perfil extends CI_Controller {

	public function index()
	{
		$this->load->model("perfil_model");
		$data['dados_perfil'] = $this->perfil_model->getForId();
		$this->load->view("author/index", $data);
	}

	public function editar() {

		$this->load->library('session');
		$this->load->model('perfil_model');
		$data['dados_perfil'] = $this->perfil_model->getForId();
		$this->load->view('author/editar', $data);
	}

	public function salvar_edicao($arr_dados = array() ) {
		if($this->session->userdata('id') != null) {
            $idLogado = $this->session->userdata('id');
            $this->load->model('perfil_model');
            $arr_dados = array('nome' => $_POST['nome'],
                                'email' => $_POST['email'],
                                'cidade' => $_POST['cidade'],
                                'profissao' => $_POST['profissao'],
                                'foto' => $_POST['foto'],
                                'ativo' => 1);
            $this->db->where('id_usuario', $idLogado);
            $this->db->update('usuario', $arr_dados);
            $id = $this->uri->segment(3);
            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('structure/menuLeftAdmin');
            $this->load->view('structure/footer');

            redirect('/' , 'refresh');

        } else {
            redirect('/login/', 'refresh');   
        }
	}

}
