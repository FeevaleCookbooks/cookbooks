<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class receita extends CI_Controller {


    public function __construct() {
          parent::__construct();


        $this->session->set_userdata("id",'5');

        $this->load->model('receita_model');

     }


    public function index() {

        if($this->session->userdata('id') != null){

            $idLogado = $this->session->userdata('id');
            $data['receita'] = $this->receita_model->getAllRecipes();
            
        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function add(){

        $data['row_recipe'] = $this->receita_model->getAllRecipes();
        
        $this->load->view("recipe/add.php", $data);

    }

    public function inserir_receita(){

        if($this->session->userdata('id') != null){

            $_POST["foto"] = "endereco_foto";
            
            $idLogado = $this->session->userdata('id');

            $arr_dados = array('id_usuario' => $this->session->userdata('id'), 
                               'nome' => $_POST['nome_receita'],
                               'ingredientes' => $_POST['ingredientes'],
                               'modo_preparo' => $_POST['modo_preparo'],
                               'categoria' => $_POST['categoria'],
                               'foto' => $_POST['foto'], 
                               'observacao' => $_POST['observacao'], 
                               'ativo' =>  $_POST['ativo']);

            $this->receita_model->insertRecipe($arr_dados);

            redirect(base_url().'receita/lista', 'refresh');

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