<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BannerAnuncios
 *
 * @author cubano
 */
class BannerAnuncios {
    
    public function bannerTopo(){
        global $db;
        
        $sql = "SELECT id,nome_imagem FROM site_banner WHERE status = 1";
        $rowsBanner = $db->execute($sql);
        
        return $rowsBanner;
    }
    
}

?>
