<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class receita extends CI_Controller {


    public function __construct() {
          parent::__construct();

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
      $config['upload_path'] = './assets/upload/recipe/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['image_width']  = '1140';

      $this->load->library("upload", $config);

      $_POST['foto'] = $_FILES['foto']['name'];

      if (! $this->upload->do_upload('foto')){
        $error = array('error' => $this->upload->display_errors());

        redirect(base_url().'receita/add', 'refresh');
      } else {

          if($this->session->userdata('id') != null){
              
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
              redirect(base_url().'receita/add', 'refresh');
          }
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
                               'observacao' => $_POST['observacao'], 
                               'ativo' =>  $_POST['ativo']);

            if(!empty($_FILES['foto']['name'])){
              $arr_dados = array('foto' => $_FILES['foto']['name']);

              $config['upload_path'] = './assets/upload/recipe/';
              $config['allowed_types'] = 'gif|jpg|png';
              $config['image_width']  = '1140';

              $this->load->library("upload", $config);

              $this->upload->do_upload('foto');
            }

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

    public function interna($id){

      if($this->session->userdata('id') != null){

        $this->load->model('receita_model');
        $this->load->model('perfil_model');
        $data['receita'] = $this->receita_model->getForId($id);
        $usuario = $this->perfil_model->getForId($data);
        $this->load->view("recipe/index.php", $data);
        
      }

    }
   
    public function listar () {
        if($this->session->userdata('id') != null){
            $data['receitas'] = $this->receita_model->getAllRecipesSemIdUsuario();
            $data['receita'] = $this->receita_model->getAllRecipes();
        }else{
          redirect('/login/', 'refresh');
        }

        $this->load->view("recipe/list-recipes.php", $data);  
    }
}