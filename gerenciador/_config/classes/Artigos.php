<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Artigos
 *
 * @author arch
 */
class Artigos {
   
    public function GetDetalheArtigo($id){
        global $db;
        
        $sql = "SELECT * FROM site_artigocientifico WHERE id = $id";
        $rowsDetArtigo = $db->execute($sql);
        
        return $rowsDetArtigo;
                
    }
    
    public function GetDetalheArtigoTecnico($id){
        global $db;
        
        $sql = "SELECT * FROM site_artigotecnico WHERE id = $id";
        $rowsDetArtigoTecnico = $db->execute($sql);
        
        return $rowsDetArtigoTecnico;
                
    }
}

?>
