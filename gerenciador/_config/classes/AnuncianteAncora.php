<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Anunciante
 *
 * @author arch
 */
class AnuncianteAncora {
    
    public function getAllAnunciante(){
        global $db;
        
        $sql = "SELECT * FROM site_anunciante WHERE status = 1";
        $rowsAnunciante = $db->execute($sql);
        
        return $rowsAnunciante;
    }
    
     public function getAllAncora(){
        global $db;
        
        $sql = "SELECT * FROM site_ancora WHERE status = 1";
        $rowsAnunciante = $db->execute($sql);
        
        return $rowsAnunciante;
    }
}

?>
