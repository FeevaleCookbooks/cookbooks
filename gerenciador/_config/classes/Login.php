<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author cubano
 */
class Login {

    public function Login($log, $pass) {
        global $db;

        $sql = "SELECT id, user, pass, status_logado 
                FROM site_login_pass 
                WHERE user = '$log' AND pass = '$pass'";

        $rowlogin = $db->execute($sql);

        return $rowlogin;
    }

    public function statusLogado($statusLogado, $user, $pass) {
        global $db;

        $sql = "UPDATE site_login_pass 
                SET status_logado = '$statusLogado' 
                WHERE user = '$user' AND pass = '$pass'";

        $rowsStatusLogado = $db->execute($sql);

        return $rowsStatusLogado;
    }


}

?>
