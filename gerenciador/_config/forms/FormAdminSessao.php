<?php

class FormAdminSessao extends Form {

    function FormAdminSessao() {
	parent::Form("admin_sessao");
	$this->flags = "UI";
    }

    function configFields() {

	$f = $this->newField("char", array("id", "ID"));
	$f->is_static = true;
	$this->addField($f, "LOFU");

	$f = $this->newField("char", array("nome", "Nome"));
	$f->maxlength = "100";
	$this->addField($f, "LOFIU");
    }

}

?>