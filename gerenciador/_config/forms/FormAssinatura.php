<?php

class FormAssinatura extends Form {

    function FormAssinatura() {
        parent::Form("site_contrato_assinatura");
        $this->flags = "LOFIUD";
    }

    function configFields() {
       
        $f = $this->newField("char", array("id", "ID"));
        //$f->is_static = true;
        $this->addField($f, "L");

        $f = $this->newField("htmlEditor", array("texto", "Contrato", 'upload/htmlEditor/'));
        $this->addField($f, "IU");
        
        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>