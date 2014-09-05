<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

class Finalidade extends CI_Controller {

    public function index() {

        if($this->session->userdata('nomeLogado') != null){

            $this->load->model('finalidade_model');
            $data['finalidade'] = $this->finalidade_model->getAll();

            $idLogado = $this->session->userdata('id');

            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('structure/menuLeftAdmin', $data);
            $this->load->view('finalidade_view');
            $this->load->view('structure/footer');

        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function inserir_finalidade(){

        if($this->session->userdata('nomeLogado') != null){

            $idLogado = $this->session->userdata('id');

            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('structure/menuLeftAdmin');
            $this->load->view('finalidadeForm_view');
            $this->load->view('structure/footer');

        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function create_finalidade(){

        if($this->session->userdata('nomeLogado') != null){

            $nomeFinalidade = $_POST['nomeFinalidade'];

            $arr_dados = array("nome" => $nomeFinalidade, "status" => 1);

            $this->load->model('finalidade_model');

            $this->finalidade_model->insertFinalidade($arr_dados);
            
            print "<script type=\"text/javascript\">alert('Finalidade criada com sucesso');</script>";    

            redirect('/finalidade/', 'refresh');
            
        }else{

            redirect('/login/', 'refresh');            

        }

    }

    public function editar_finalidade(){

        if($this->session->userdata('nomeLogado') != null){

            $this->load->model('finalidade_model');

            $id = $this->uri->segment(3);
            $data['finalidade'] = $this->finalidade_model->getForId($id);

            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('structure/menuLeftAdmin');
            $this->load->view('finalidadeFormUpdate_view', $data);
            $this->load->view('structure/footer');


        }else{

        }
    }

    public function update_finalidade(){

        if($this->session->userdata('nomeLogado') != null){

            $nomeFinalidade = $_POST['nomeFinalidade'];

            $id = $this->uri->segment(3);
            $arr_dados = array("nome" => $nomeFinalidade, "status" => 1);

            $this->load->model('finalidade_model');
            $this->finalidade_model->updateFinalidade($id, $arr_dados);
            
            print "<script type=\"text/javascript\">alert('Finalidade alterada com sucesso');</script>";    

            redirect('/finalidade/', 'refresh');
            
        }else{

            redirect('/login/', 'refresh');            

        }

    }

    public function deletar_finalidade(){

        if($this->session->userdata('nomeLogado') != null){

            $id = $this->uri->segment(3);

            $this->load->model('finalidade_model');
            $this->finalidade_model->deleteFinalidade($id);

            redirect('/finalidade/', 'refresh');
            
        }else{

            redirect('/login/', 'refresh');            

        }

    }

   

}