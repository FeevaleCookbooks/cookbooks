<?php

class FormAdminLogManager extends Form {

    function FormAdminLogManager() {
	parent::Form("admin_log");

	$this->flags = "LOU";
	$this->setDefaultOrder("datahora#desc");
	$this->page_size = 100;
	$this->enable_update = false;
    }

    function configFields() {
	$f = $this->newField("date", array("datahora", "Data / Hora"));
	$f->setInputType("datetime");
	$f->is_static = true;
	$f->is_sql_affect = false;
	$f->setFilterType(1);
	$this->addField($f, "LOFU");

	$f = $this->newField("items", array("id_usuario", "Usuсrio"));
	$f->addElementsByTable('admin_usuario');
	$f->is_static = true;
	$this->addField($f, "LOFU");

	$f = $this->newField("char", array("ip", "IP"));
	$f->is_static = true;
	$this->addField($f, "LOFU");

	$f = $this->newField("char", array("acao", "Aчуo"));
	$f->is_static = true;
	$this->addField($f, "LOFU");

	$f = $this->newField("char", array("descricao", "Descriчуo"));
	$f->is_static = true;
	$this->addField($f, "LOFU");

	$f = $this->newField("char", array("query", "SQL"));
	$f->setInputType("textarea");
	$f->is_static = true;
	$this->addField($f, "FU");
    }

}

?>