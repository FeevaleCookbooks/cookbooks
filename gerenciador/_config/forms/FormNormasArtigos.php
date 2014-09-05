<?php

class FormNormasArtigos extends Form {

    function FormNormasArtigos() {
        parent::Form("site_artigonormas");
        $this->flags = "LOFIUD";
    }

    function configFields() {
       
        $f = $this->newField("char", array("id", "ID"));
        //$f->is_static = true;
        $this->addField($f, "L");

        $f = $this->newField("htmlEditor", array("texto", "Normas", 'upload/htmlEditor/'));
        $this->addField($f, "IU");
        
        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>