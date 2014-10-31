<?php


class perfil extends CI_Controller {

	public function index(){
		$this->load->model("perfil_model");
		$data['dados_perfil'] = $this->perfil_model->getForId();
		
		$data['receita'] = $this->perfil_model->getReceitasByPerfil();


		$this->load->view("author/index", $data);
	}

	public function editar() {
		$this->load->library('session');
		$this->load->model('perfil_model');
		$data['dados_perfil'] = $this->perfil_model->getForId();
		$this->load->view('author/editar', $data);
	}

	public function getReceitasByPerfil(){

		$this->load->model('perfil_model');
		$this->perfil_model->get)

	}

	public function salvar_edicao($arr_dados = array() ) {
		if($this->session->userdata('id') != null) {
            $this->load->model('usuario_model');

            $arr_dados = array(
                'nome' => $_POST['nome'],
                'cidade' => $_POST['cidade'],
                'profissao' => $_POST['profissao'],
                'observacao' => $_POST['observacao'],
                'foto' => $_POST['foto'],
            );

            $this->usuario_model->updateById($arr_dados);

            redirect('/perfil' , 'refresh');
        } else {
            redirect('/login' , 'refresh');
        }
	}

}
