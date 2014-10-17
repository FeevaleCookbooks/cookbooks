<?php


class Author extends CI_Controller {


	public function index()
	{
		$this->load->view('author/index');
		$this->load->library('session');

		$user = $_POST['email'];
        $pass = sha1($_POST['pass']);

        $this->load->model('perfil_model');

        $data['id_usuario'] = $this->perfil_model->getForId($user);
	}

	public function editar() {

		$this->load->view('perfil/editar');
		$this->load->library('session');
		$this->load->model('perfil_model');
	}


}
