<?php

class FormMateria extends Form {

    function FormMateria() {
        parent::Form("site_materia");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        $f = $this->newField("char", array("abreviado", "Abreviaчуo"));
        //$f->is_static = false;
        $f->is_required = false;
        $this->addField($f, "LOFIU");

        $f = $this->newField("char", array("titulo", "Titulo"));
        //$f->is_static = false;
        $f->is_required = false;
        $this->addField($f, "LOFIU");

        $f = $this->newField("htmlEditor", array("conteudo", "Conteudo", 'upload/htmlEditor/'));
        $this->addField($f, "IU");

        $f = $this->newField("imageUpload", array("image", "botao (253x37)", "upload/site_bts/"));
        $f->addThumb("#ID#", 267, 50, 3);
        $f->extensions_accept = array("jpg", "png");
        $this->addField($f, "IU");

        $f = $this->newField("imageUpload", array("imageMateria", "Foto sobre a Materia (230x177)", "upload/site_materia/"));
        $f->addThumb("#ID#", 230, 177, 1);
        $f->extensions_accept = array("jpg");
        $this->addField($f, "IU");

        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>