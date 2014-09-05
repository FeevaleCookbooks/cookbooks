<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Materias
 *
 * @author cubano
 */
class Materias {

    public function getAllBtsMaterias() {
        global $db;

        $sql = "SELECT * FROM site_materia WHERE status = 1";
        $rowsAllBts = $db->execute($sql);

        return $rowsAllBts;
    }

    public function detalheMaterias($id) {
        global $db;

        $sql = "SELECT * FROM site_materia WHERE id = $id AND status = 1";
        $rowsDetalhe = $db->execute($sql);

        return $rowsDetalhe;
    }

    public function materiaRelacionada($idRelacionada) {
        global $db;

        $sql = "SELECT * FROM site_materia_relacionada where id_materia = $idRelacionada";
        $rowsMateriaRelacionda = $db->execute($sql);

        return $rowsMateriaRelacionda;
    }

    public function materiaRelacionadaExibindo($idRelacionada) {
        global $db;

        $sql = "SELECT * FROM site_materia_relacionada where id = $idRelacionada";
        $rowsMateriaRelaciondaExibida = $db->execute($sql);

        return $rowsMateriaRelaciondaExibida;
    }

    public function materiasHome() {
        global $db;

        $sql = "SELECT * FROM site_home_destaque where status = 1 ORDER BY RAND() LIMIT 4";
        $rowsMateriaHome = $db->execute($sql);

        return $rowsMateriaHome;
    }

    public function materiasHomeDetalhes($id) {
        global $db;

        $sql = "SELECT * FROM site_home_destaque where id = $id AND status = 1";
        $rowsMateriaHome = $db->execute($sql);

        return $rowsMateriaHome;
    }

}

?>
