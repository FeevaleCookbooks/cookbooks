<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MinhaConta
 *
 * @author arch
 */
class MinhaConta {

    public function verificaConta($userLogin) {
        global $db;

        $sql = "SELECT * FROM site_pessoa_juridica WHERE email = '$userLogin' AND status = 1";
        $rowVerifica = $db->execute($sql);

        if ($rowVerifica->recordcount == '0' || $rowVerifica->recordcount == null) {
            
            $sql = "SELECT * FROM site_pessoa_fisica WHERE email = '$userLogin' AND status = 1";
            $rowVerifica = $db->execute($sql);
        }
        
        return $rowVerifica;
    }

}

?>
