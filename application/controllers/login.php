<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

class Login extends CI_Controller {

	public function index(){

		$this->load->view('structure/head');
        $this->load->view('structure/header');
        $this->load->view('structure/topo');
        $this->load->view('login/index');
        $this->load->view('structure/footer');

	}

    public function checkLogin(){
        $this->load->library('session');

        $user = $_POST['email'];
        $pass = sha1($_POST['pass']);
        $this->load->model('login_model');

        $data['login'] = $this->login_model->logar($user, $pass);

        if($data['login']){

            $this->session->unset_userdata('nomeLogado');
            $this->session->unset_userdata('id');
            
            $this->session->set_userdata('nomeLogado',$data['login'][0]['nome']);
            $this->session->set_userdata('id',$data['login'][0]['id_usuario']);
            $data['nomeLog'] = $this->session->userdata('nomeLogado'); 
            $data['idLog'] = $this->session->userdata('id');

            
            redirect('/perfil/', 'refresh');                
        }else{
            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('login/index');
            $this->load->view('structure/footer');

            print "<script type=\"text/javascript\">alert('Login ou Senha não conferem');</script>";

        }


    }

    public function logout(){
        $this->session->unset_userdata('nomeLogado');
        $this->session->unset_userdata('id');

        redirect('login/', 'refresh');       

    }

}