<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploadArtigo
 *
 * @author cubano
 */
class UploadArtigoTecnico {

    public function uploadPdfTecnico($emailArtigoTecnico, $fileNameTecnico, $fileTypeTecnico) {
        global $db;
        global $input;

        $sql = "INSERT INTO site_artigotecnico(user,nome,arquivo,status) VALUES('$emailArtigoTecnico','$fileNameTecnico','$fileTypeTecnico','0')";
        $rowsInsereArquivoTecnico = $db->execute($sql);

        return $rowsInsereArquivoTecnico;
    }

    public function uploadSelectPdfTecnico($fileNameTecnico) {
        global $db;
        global $input;

        $sqlSelect = "SELECT id FROM site_artigotecnico WHERE nome = '$fileNameTecnico' AND status = 0";
        $rowsSelectArquivoTecnico = $db->execute($sqlSelect);

        return $rowsSelectArquivoTecnico;
    }

    public function getAllArtigoTecnico() {
        global $db;
        global $input;

        $sql = "SELECT * FROM site_artigotecnico WHERE status = 1";
        $rowsSelectArtigoTecnico = $db->execute($sql);

        return $rowsSelectArtigoTecnico;
    }
    
    public function normasArtigo(){
        global $db;
        
        $sql = "SELECT * FROM site_artigonormas WHERE status = 1";
        $rowsNormas = $db->execute($sql);
        
        return $rowsNormas;
    }

}

?>
