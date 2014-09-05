<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UFCidade
 *
 * @author cubano
 */
class UFCidade {

    public function UFEstado() {
        global $db;

        $sql = "SELECT * FROM global_estado";
        $rowsEstado = $db->execute($sql);

        return $rowsEstado;
    }

    public function UfCidade($id) {
        global $db;

        $sql = "SELECT gc.id, gc.nome FROM global_cidade as gc
                JOIN global_estado as ge ON ge.id = gc.id_estado
                WHERE ge.id = '$id' ORDER BY gc.nome";

        $rowsCidadeEstado = $db->execute($sql);

        $arr_cidades = array();
        $c = 0;

        while (!$rowsCidadeEstado->EOF) {
            $arr_cidades[$c]['nome'] = $rowsCidadeEstado->fields('nome');
            $arr_cidades[$c]['id'] = $rowsCidadeEstado->fields('id');
            $c++;
            $rowsCidadeEstado->moveNext();
        }
        return $arr_cidades;
    }

}

?>
