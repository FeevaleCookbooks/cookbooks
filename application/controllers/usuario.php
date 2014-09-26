<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

class usuario extends CI_Controller {
    
    
	public function index(){

        $this->load->view('usuario/index');

	}

    public function inserir_usuario() {
            $this->load->model('usuario_model');
            if ($this->form_validation->run('usuario_form') != FALSE){    
            $arr_dados = array('nome' => $_POST['nome'],
                                'email' => $_POST['email'],
                                'senha' => $_POST['senha'],
                                'cidade' => $_POST['cidade'],
                                'profissao' => $_POST['profissao'],
                                'foto' => $_POST['foto'],
                                'ativo' => 1);
            $this->usuario_model->insertUser($arr_dados);
            } else {
                $this->load->view('usuario/index');
            }
            
    }

    public function editar_usuario() {
        if($this->session->userdata('id') != null) {
            $idLogado = $this->session->userdata('id');

            $this->load->model('usuario_model');
            $arr_dados = array('nome' => $_POST['nome'],
                                'email' => $_POST['email'],
                                'senha' => $_POST['senha'],
                                'cidade' => $_POST['cidade'],
                                'profissao' => $_POST['profissao'],
                                'foto' => $_POST['foto'],
                                'ativo' => 1);
            $id = $this->uri->segment(3);
            $data['usuario'] = $this->usuario_model->getForId($id);
            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('login_view');
            $this->load->view('structure/menuLeftAdmin');
            $this->load->view('finalidadeFormUpdate_view', $data);
            $this->load->view('structure/footer');

        } else {
            redirect('/login/', 'refresh');   
        }
    }
}

?>