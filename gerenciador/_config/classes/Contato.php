<?php

class Contato {

    public function sendContato($nome, $email, $estado, $cidade, $mensagem){
        global $db;
        global $input;

        $sql = "INSERT INTO site_contato(nome,email,estado,cidade,mensagem)
                VALUES ('$nome','$email','$estado','$cidade','$mensagem')";
        $rowsEnvio = $db->execute($sql);

        return $rowsEnvio;
    }

    public function envioContatoNews($nome, $email) {
        global $db;

        $sqlSelect = "SELECT nome,email FROM site_contato_newsletter WHERE nome = '$nome' AND email = '$email' AND status = 1";
        $rowsNewsBusca = $db->execute($sqlSelect);

        if ($rowsNewsBusca->fields == '') {

            $sql = "INSERT INTO site_contato_newsletter (nome, email, status) VALUES ('$nome','$email','1')";
            $rowsNewsletter = $db->execute($sql);
            return $rowsNewsletter;
        }
    }

    //Contrato

    public function ContratoAssinatura() {
        global $db;

        $sql = "SELECT * FROM site_contrato_assinatura WHERE status = 1";
        $rowsContrato = $db->execute($sql);

        return $rowsContrato;
    }

    public function EsqueciPasswordFisica($emailEsqueciF, $cpfEsqueciF) {
        global $db;

        $sql = "SELECT * FROM site_pessoa_fisica WHERE email = '$emailEsqueciF' 
                AND cpf = '$cpfEsqueciF' AND `status`=1";
        $rowsSenhaEsqueciF = $db->execute($sql);

        return $rowsSenhaEsqueciF;
    }

    public function EsqueciPasswordJuridica($emailEsqueciJ, $cnpjEsqueciJ) {
        global $db;

        $sql = "SELECT * FROM site_pessoa_juridica WHERE email = '$emailEsqueciJ' 
                AND cnpj = '$cnpjEsqueciJ' AND `status`=1";
        $rowsSenhaEsqueciJ = $db->execute($sql);

        return $rowsSenhaEsqueciJ;
    }

}

?>