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
class UploadArtigo {

    public function uploadPdf($emailArtigo, $fileName, $fileType) {
        global $db;
        global $input;

        $sql = "INSERT INTO site_artigocientifico(user,nome,arquivo,status) VALUES('$emailArtigo','$fileName','$fileType','0')";
        $rowsInsereArquivo = $db->execute($sql);

        return $rowsInsereArquivo;
    }

    public function uploadSelectPdf($fileName) {
        global $db;
        global $input;

        $sqlSelect = "SELECT id FROM site_artigocientifico WHERE nome = '$fileName' AND status = 0";
        $rowsSelectArquivo = $db->execute($sqlSelect);

        return $rowsSelectArquivo;
    }

    public function getAllArtigo() {
        global $db;
        global $input;

        $sql = "SELECT * FROM site_artigocientifico WHERE status = 1";
        $rowsSelectArtigo = $db->execute($sql);

        return $rowsSelectArtigo;
    }
    
    public function normasArtigo(){
        global $db;
        
        $sql = "SELECT * FROM site_artigonormas WHERE status = 1";
        $rowsNormas = $db->execute($sql);
        
        return $rowsNormas;
    }

}

?>
