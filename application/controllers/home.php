<?php


class Home extends CI_Controller {


	public function index(){

		$this->load->model('receita_model');
		$this->load->model('usuario_model');

		$data['recipes'] = $this->receita_model->getAllRecipesAndUser();
		$data['chefs'] = $this->usuario_model->getForId();
		$data['receitas'] = $this->receita_model->getAllRecipesAndUser(6);

		$this->load->view('home/index', $data);
	}


}
