<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

class receita extends CI_Controller {


    public function index() {

        if($this->session->userdata('id') != null){

            $idLogado = $this->session->userdata('id');

            $this->load->model('receita_model');
            $data['receita'] = $this->receita_model->getAllRecipes();
            
            //$this->load->view('structure/head');
            //$this->load->view('structure/header');
            //$this->load->view('structure/topo');
            //$this->load->view('structure/menuLeftAdmin', $data);
            //$this->load->view('finalidade_view');
            //$this->load->view('structure/footer');

        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function inserir_receita(){

        if($this->session->userdata('id') != null){
            
            $idLogado = $this->session->userdata('id');

            $this->load->model('receita_model');
            $arr_dados = array('id_usuario' => $this->session->userdata('id'), 
                               'nome' => $_POST['nome_receita'],
                               'ingredientes' => $_POST['ingredientes'],
                               'modo_preparo' => $_POST['modo_preparo'],
                               'categoria' => $_POST['categoria'],
                               'foto' => $_POST['foto'], 
                               'observacao' => $_POST['observacao'], 
                               'ativo' => 1);

            //$this->load->view('structure/head');
            //$this->load->view('structure/header');
            //$this->load->view('structure/topo');
            //$this->load->view('structure/menuLeftAdmin');
            //$this->load->view('finalidadeForm_view');
            //$this->load->view('structure/footer');

        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function editar_receita(){

        if($this->session->userdata('nomeLogado') != null){

            $this->load->model('receita_model');

            $arr_dados = array('id_usuario' => $this->session->userdata('id'), 
                               'nome' => $_POST['nome_receita'],
                               'ingredientes' => $_POST['ingredientes'],
                               'modo_preparo' => $_POST['modo_preparo'],
                               'categoria' => $_POST['categoria'],
                               'foto' => $_POST['foto'], 
                               'observacao' => $_POST['observacao'], 
                               'ativo' => 1);

            $id = $this->uri->segment(3);
            $data['receita'] = $this->receita_model->getForId($id);

            $this->load->view('structure/head');
            $this->load->view('structure/header');
            $this->load->view('structure/topo');
            $this->load->view('structure/menuLeftAdmin');
            $this->load->view('finalidadeFormUpdate_view', $data);
            $this->load->view('structure/footer');

        }else{

            redirect('/login/', 'refresh');   

        }
    }

    public function deletar_receita(){

        if($this->session->userdata('nomeLogado') != null){

            $id = $this->uri->segment(3);

            $this->load->model('receita_model');
            $this->receita_model->deleteRecipe($id);

            redirect('/receita/', 'refresh');   
            
        }else{

            redirect('/login/', 'refresh');            

        }

    }

   

}