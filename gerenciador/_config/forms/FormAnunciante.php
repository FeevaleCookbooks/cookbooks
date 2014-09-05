<?php

class FormAnunciante extends Form {

    function FormAnunciante() {
        parent::Form("site_anunciante");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        
        $f = $this->newField("char", array("anunciante", "Titulo"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
         $f = $this->newField("char", array("link", "Link"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
        $f = $this->newField("imageUpload", array("imageAnunciante", "Imagem Anunciante(png)", "upload/site_anunciante/"));
        $f->addThumb("#ID#", 185, 38, 1);
        $f->extensions_accept = array("png");
        $this->addField($f, "IU");
        
        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>