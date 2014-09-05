<?php

class FormAncora extends Form {

    function FormAncora() {
        parent::Form("site_ancora");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        
        $f = $this->newField("char", array("ancora", "Titulo"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
         $f = $this->newField("char", array("link", "Link"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");
        
        $f = $this->newField("imageUpload", array("imageAncora", "Imagem Ancora(png)", "upload/site_ancora/"));
        $f->addThumb("#ID#", 185, 32, 1);
        $f->extensions_accept = array("png");
        $this->addField($f, "IU");
        
        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>