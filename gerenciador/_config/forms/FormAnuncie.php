<?php

class FormAnuncie extends Form {

    function FormAnuncie() {
        parent::Form("site_anuncie");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        $f = $this->newField("char", array("formato", "Formato"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
        $f = $this->newField("char", array("dimensao", "Dimensões"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
        $f = $this->newField("char", array("observacao", "Observações"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
        $f = $this->newField("char", array("investimento", "Investimento"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>