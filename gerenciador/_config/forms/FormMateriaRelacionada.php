<?php

class FormMateriaRelacionada extends Form {

    function FormMateriaRelacionada() {
        parent::Form("site_materia_relacionada");
        $this->flags = "LOFIUD";
    }

    function configFields() {
       
        $f = $this->newField("char", array("titulo", "Titulo"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("htmlEditor", array("conteudo", "Conteudo", 'upload/htmlEditor/'));
        $this->addField($f, "IU");

        $f = $this->newField("imageUpload", array("imageMateria", "Foto sobre a Materia (230x177)", "upload/site_materia_relacionada/"));
        $f->addThumb("#ID#", 230, 177, 4);
        $f->extensions_accept = array("jpg");
        $this->addField($f, "IU");
        
        $f = $this->newField("items", array("id_materia", "Materia Relacionada"));
        $f->addElementsByTable('site_materia', "id", "titulo");
        $f->is_required = false;
        $this->addField($f, "FIU");
        
        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>