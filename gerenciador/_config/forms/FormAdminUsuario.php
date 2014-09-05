<?php

class FormAdminUsuario extends Form {

    function FormAdminUsuario() {
	parent::Form("admin_usuario");
    }

    function configFields() {
	$f = $this->newField("char", array("nome", "Nome"));
	$f->maxlength = "100";
	$this->addField($f, "LOFIU");

	$f = $this->newField("char", array("email", "E-mail"));
	$f->loadConfig("email");
	$f->maxlength = "150";
	$this->addField($f, "LOFIU");

	$f = $this->newField("items", array("nivel", "Nível de Usuário"));
	$f->setInputType('radio');
	$f->addElementsByArray(array('1' => 'Master', '2' => 'Administrador'));
	$this->addField($f, "LOFIU");

	$f = $this->newField("ativo");
	$f->value_initial = 1;
	$this->addField($f, "LOFIU");

	$f = $this->newField("html", array("separador"));
	$this->addField($f);

	$f = $this->newField("char", array("usuario", "Usuário"));
	$f->maxlength = "60";
	$this->addField($f, "IU");

	$f = $this->newField("password", array("senha"));
	$f->maxlength = "15";
	$this->addField($f, "UI");

	$f = $this->newField('html', array('box'));
	$this->addField($f);

	$f = $this->newField('html', array('label', 'Permissões'));
	$this->addField($f);

	$f = $this->newField('multiItems', array('sessao', '', 'admin_usuario_sessao', 'id_usuario', 'id_sessao'));
	$f->addElementsByTable('admin_sessao');
	$this->addField($f, 'IU');
    }

}

?>