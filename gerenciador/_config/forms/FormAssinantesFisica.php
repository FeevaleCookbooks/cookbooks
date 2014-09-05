<?php

class FormAssinantesFisica extends Form {

    function FormAssinantesFisica() {
        parent::Form("site_pessoa_fisica");
        $this->flags = "LOFIU";
    }

    function configFields() {
        $f = $this->newField("char", array("nome", "Nome"));
        $f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("char", array("sobrenome", "Sobrenome"));
        $f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("char", array("cpf", "CPF"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("rg", "RG"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("cep", "CEP"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("endereco", "Endereço"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("numero", "Nº"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("complemento", "Complemento"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("bairro", "Bairro"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("cidade", "Cidade"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("uf", "UF"));
        $f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("char", array("fone", "Fone"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("fax", "FAX"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("email", "Email"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("periodo", "Periodo de Contratação"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("datacadastro", "Data do Cadastro"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("datafinalcadastro", "Data de Término do contrato"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("numero_pedido", "Numero Boleto Gerado"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("char", array("numero_pedido_segundo_boleto", "Numero Pedido Segundo Boleto(Caso houver)"));
        $f->is_static = true;
        $this->addField($f, "FIU");

        $f = $this->newField("ativo");
        $f->value_initial = 0;
        $this->addField($f, "LOFIU");
    }

    public function onPosPost($tmp_flag) {
        global $db;
        global $input;
        global $load;

        $id = $_GET['id'];

        $sql = "SELECT * FROM site_pessoa_fisica WHERE id = $id";
        $rowsPessoa = $db->execute($sql);

        if ($rowsPessoa->fields('status') == '1') {
            $insereLogin = "INSERT INTO site_login_pass(user,pass,status,status_logado)
                            VALUES ('" . $rowsPessoa->fields('email') . "','" . md5($rowsPessoa->fields('senha')) . "','1','0')";
            $db->execute($insereLogin);

            $load->system('library/Email.php');
            $o_email = new Email();

            $o_email->from = 'tecnicouro@tecnicouro.com.br';
            $o_email->subject = 'Login e Senha para a Revista Tecnicouro Online';

            $o_email->content = "<div class='login' style='font-family: arial; font-size: 14px; color: #1A945A; margin: 0 auto;'>
                                     Seu Login: " . $rowsPessoa->fields('email') . "<br>" .
                    "Sua Senha: " . $rowsPessoa->fields('senha') . "<br>" .
                    "Dúvidas, pode entrar em contato pelo email contato@tecnicouro.com.br ou por http://www.tecnicouro.com.br/site/contato/"
                    . "</div>";

            $o_email->to = $rowsPessoa->fields('email');

            if ($o_email->send()) {
                $envio = true;
            } else {
                $envio = false;
            }

            if ($envio) {
                $input->setSession('envio', 'Usuário Ativado com Sucesso');
            } else {
                $input->setSession('envio', 'Erro ao Ativar Usuário');
            }
            echo $input->session('envio');
        } elseif ($rowsPessoa->fields('status') == '0') {

            $deletaLogin = "DELETE FROM site_login_pass WHERE user = '" . $rowsPessoa->fields('email') . "' AND pass ='" . $rowsPessoa->fields('senha') . "'";
            $db->execute($deletaLogin);

            $load->system('library/Email.php');
            $o_email = new Email();

            $o_email->from = 'tecnicouro@tecnicouro.com.br';
            $o_email->subject = 'Login e Senha para a Revista Tecnicouro Online';

            $o_email->content = "<div class='login' style='font-family: arial; font-size: 14px; color: #1A945A; margin: 0 auto;'>
                                 Seu Login: 'O período de parceria da Tecnicouro com você foi temporariamente' <br>" .
                    "devido ao término do seu contrato. Renove nossa aliança novamente acessando <a href='http://www.tecnicouro.com.br/assine/'>Tecnicouro</a><br>" .
                    "Dúvidas pode entrar em contato pelo email xxx@ibtec.org.br"
                    . "</div>";

            $o_email->to = $rowsPessoa->fields('email');
            
            if ($o_email->send()) {
                $envio = true;
            } else {
                $envio = false;
            }

            if ($envio) {
                $input->setSession('envio', 'Usuário Desativado com Sucesso');
            } else {
                $input->setSession('envio', 'Erro ao Desativar Usuário');
            }
            echo $input->session('envio');
        }
    }

}

?>