<?php

class FormDestaqueHome extends Form {

    function FormDestaqueHome() {
        parent::Form("site_home_destaque");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        
        $f = $this->newField("char", array("titulo", "Titulo"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("htmlEditor", array("conteudo", "Conteudo", 'upload/htmlEditor/'));
        $this->addField($f, "IU");
        
        $f = $this->newField("imageUpload", array("imageBtHome", "botao (151x29)", "upload/site_bts_sel/"));
        $f->addThumb("#ID#", 301, 54, 3);
        $f->extensions_accept = array("jpg", "png");
        $this->addField($f, "IU");
        
        $f = $this->newField("imageUpload", array("imageDestaque", "imagem ", "upload/site_materia_home/"));
        $f->addThumb("#ID#", 285, 240, 4);
        $f->extensions_accept = array("jpg", "png");
        $this->addField($f, "IU");

        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>