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

          $config['upload_path'] = './assets/upload/recipe/';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['image_width']  = '1140';

          $this->load->library("upload", $config);

          $_POST['foto'] = $_FILES['foto']['name'];

          $this->upload->do_upload('foto');
            
            if ($this->form_validation->run('usuario_form') != FALSE){    
            $arr_dados = array('nome' => $_POST['nome'],
                                'email' => $_POST['email'],
                                'senha' => sha1($_POST['senha']),
                                'cidade' => $_POST['cidade'],
                                'profissao' => $_POST['profissao'],
                                'foto' => $_POST['foto'],
                                'ativo' => 1);
            $this->usuario_model->insertUser($arr_dados);

            $this->load->view('usuario/index');
            } else {
                $this->load->view('usuario/index');
            }
    }

}

?>