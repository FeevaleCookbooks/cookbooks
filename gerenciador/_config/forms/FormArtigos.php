<?php

class FormArtigos extends Form {

    function FormArtigos() {
        parent::Form("site_artigocientifico");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        $f = $this->newField("char", array("user", "Email"));
        $f->is_static = true;
        $this->addField($f, "LOFU");

        $f = $this->newField("char", array("nome", "Nome do Artigo"));
        $f->is_static = true;
        $this->addField($f, "LOFU");
        
        $f = $this->newField("uploadArquivo", array("arquivo", "Artigo", "upload/site_artigo/"));
        $f->setFileName("#ID#");
        $f->extensions_accept = array("pdf");
        $f->is_required = false;
        $this->addField($f, "U");
       
        $f = $this->newField("ativo");
        $f->value_initial = 0;
        $this->addField($f, "LOFIU");
    }

}

?>