<?php

/*
 * @author luan
 */

class Busca {

    public function busca($busca) {
        global $db;
        
        $sql = "SELECT * FROM site_materia as sm 
                WHERE sm.conteudo LIKE '%" . $busca . "%' 
                OR sm.titulo LIKE '%" . $busca . "%' 
                AND sm.status = 1
                ";

        $rowsBusca = $db->execute($sql);

        return $rowsBusca;
    }
    
    public function buscaRelacionada($busca){
        global $db;
        
        $sql_relacionada = "SELECT * FROM site_materia_relacionada as smr 
                            WHERE smr.conteudo LIKE '%".$busca."%'
                            OR smr.titulo LIKE '%".$busca."%'
                            AND smr.status = 1
                            ";
        
        $rowsBuscaRelacionada = $db->execute($sql_relacionada);
        
        return $rowsBuscaRelacionada;
    }

}

?>
