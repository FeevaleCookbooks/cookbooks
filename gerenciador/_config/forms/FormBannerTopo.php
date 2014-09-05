<?php

class FormBannerTopo extends Form {

    function FormBannerTopo() {
        parent::Form("site_banner");
        $this->flags = "LOFIUD";
    }

    function configFields() {
        $f = $this->newField("char", array("nome_imagem", "Nome Banner"));
        //$f->is_static = true;
        $this->addField($f, "LOFIU");

        $f = $this->newField("imageUpload", array("image", "Banner(608x320)", "upload/site_banner/"));
        $f->addThumb("#ID#", 608, 320, 3);
        $f->extensions_accept = array("jpg");
        $this->addField($f, "IU");

        $f = $this->newField("ativo");
        $f->value_initial = 1;
        $this->addField($f, "LOFIU");
    }

}

?>