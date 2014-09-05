<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Anuncie
 *
 * @author arch
 */
class Anuncie {
    public function anuncioRevista(){
        global $db;
        
        $sql = "SELECT * FROM site_anuncie WHERE status = 1";
        $rowsAnuncio = $db->execute($sql);
        
        return $rowsAnuncio;
    }
}

?>
