<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class receita extends CI_Controller {


    public function __construct() {
          parent::__construct();


        $this->session->set_userdata("id", "5");

        $this->load->model('receita_model');

     }


    public function index() {

        if($this->session->userdata('id') != null){

            $idLogado = $this->session->userdata('id');
            $data['receita'] = $this->receita_model->getAllRecipes();
            
        }else{

            redirect('/login/', 'refresh');

        }


        $this->load->view("recipe/index.php", $data);
    }

    public function add(){

        $data['row_recipe'] = $this->receita_model->getAllRecipes();
        
        $this->load->view("recipe/add.php", $data);

    }

    public function edit($id_receita){

        $data['row'] = $this->receita_model->getForId($id_receita);
        $data['row_recipe'] = $this->receita_model->getAllRecipes();
        
        $this->load->view("recipe/edit.php", $data);

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

            redirect(base_url().'receita/add', 'refresh');

        }else{

            redirect('/login/', 'refresh');

        }

    }

    public function editar_receita(){

        if($this->session->userdata('id') != null){

            $this->load->model('receita_model');

            $arr_dados = array('id_usuario' => $this->session->userdata('id'), 
                               'nome' => $_POST['nome_receita'],
                               'ingredientes' => $_POST['ingredientes'],
                               'modo_preparo' => $_POST['modo_preparo'],
                               'categoria' => $_POST['categoria'],
                               'foto' => $_POST['foto'], 
                               'observacao' => $_POST['observacao'], 
                               'ativo' =>  $_POST['ativo']);

            $id = $this->uri->segment(3);

            $this->receita_model->updateRecipe($id, $arr_dados);

            redirect(base_url().'receita/edit/'.$id, 'refresh');


        }else{

            redirect('/login/', 'refresh');   

        }
    }

    public function delete(){

        if($this->session->userdata('id') != null){

            $id = $this->uri->segment(3);

            $this->receita_model->deleteRecipe($id);

            $this->session->set_userdata("msg", "Receita deletada com sucesso!");

            redirect(base_url().'receita/add', 'refresh');
            
        }else{

            redirect('/login/', 'refresh');            

        }

    }

   

}