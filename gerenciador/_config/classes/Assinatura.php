<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Assinatura
 *
 * @author cubano
 */
class Assinatura {

    public function getAssinatura($cpf) {
        global $db;

        $sql = "SELECT cpf FROM site_assinatura where cpf = $cpf AND status = 1";
        $rowsValidaCliente = $db->execute($sql);

        return $rowsValidaCliente;
    }

    public function InseriPessoaFisica($nome, $sobrenome, $cpf, $rg, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $uf, $fone, $fax, $email, $senha, $resenha, $periodo, $pagamento, $numeroPedido, $numeroBoletoSegundo) {
        global $db;

        if (($periodo == '1 ano Impressa e Digital') || ($periodo == '1 ano Impressa') || $periodo == '1 ano Digital') {
            $qntDays = 375;
        } else {
            $qntDays = 750;
        }

        $sqlUF = "SELECT sigla FROM global_estado WHERE nome = '$uf'";
        $ufInsert = $db->execute($sqlUF);

        $ufSigla = $ufInsert->fields('sigla');

        $sql = "INSERT INTO site_pessoa_fisica(nome, sobrenome, cpf, rg, cep,
                    endereco, numero, complemento, bairro, cidade, uf, fone, fax,
                    email, senha, resenha, status, periodo, pagamento, datacadastro, datafinalcadastro, numero_pedido, numero_pedido_segundo_boleto) VALUES('$nome', '$sobrenome', '$cpf', '$rg', '$cep', '$endereco', 
                    '$numero', '$complemento', '$bairro', '$cidade', '$ufSigla', '$fone', '$fax', '$email', 
                    '$senha', '$resenha', 0 , '$periodo', '$pagamento', CURDATE(), DATE_ADD(CURDATE(), INTERVAL $qntDays DAY), '$numeroPedido', '$numeroBoletoSegundo')";

        $rowsPessoaFisica = $db->execute($sql);
        return $rowsPessoaFisica;
        //}else{
        //  $rowsVerificaEmail = 'Esse email já está cadastrado em nossa base de dados';
        //}
    }

    public function InseriPessoaJuridica($razaoSocial, $nomeFantasia, $cnpj, $inscricaoEstadual, $inscricaoMunicipal, $ramoAtividade, $filiais, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $uf, $fone, $fax, $email, $senha, $resenha, $periodo, $pagamento, $numeroPedido, $numeroBoletoSegundo) {
        global $db;

        if (($periodo == '1 ano Impressa e Digital') || ($periodo == '1 ano Impressa') || $periodo == '1 ano Digital') {
            $qntDays = 375;
        } else {
            $qntDays = 750;
        }

        $sqlUF = "SELECT sigla FROM global_estado WHERE nome = '$uf'";
        $ufInsert = $db->execute($sqlUF);

        $ufSigla = $ufInsert->fields('sigla');

        $sql = "INSERT INTO site_pessoa_juridica(razaosocial, nomefantasia, cnpj, 
                inscricaoestadual, inscricaomunicipal, ramoatividade, numerofiliais, cep, endereco, 
                numero, complemento, bairro, cidade, uf, fone, fax, email, senha, resenha, status, periodo, pagamento, datacadastro, datafinalcadastro, numero_pedido, numero_pedido_segundo_boleto) VALUES ('$razaoSocial', '$nomeFantasia', '$cnpj', '$inscricaoEstadual',
                '$inscricaoMunicipal','$ramoAtividade','$filiais', '$cep', '$endereco', 
                '$numero', '$complemento', '$bairro', '$cidade', '$ufSigla', '$fone', '$fax', '$email', 
                '$senha', '$resenha', 0 , '$periodo', '$pagamento', CURDATE(), DATE_ADD(CURDATE(), INTERVAL $qntDays DAY),  $numeroPedido, $numeroBoletoSegundo)";

        $rowsPessoJuridica = $db->execute($sql);
        return $rowsPessoJuridica;
    }

    public function updateUsuarioFisica($nomeAltera, $sobrenomeAltera, $cepAltera, $enderecoAltera, $NumAltera, $complementoAltera, $bairroAltera, $FoneAltera, $FaxAltera, $emailAltera) {
        global $db;

        $sql = "UPDATE site_pessoa_fisica 
                SET nome = '$nomeAltera', 
                    sobrenome = '$sobrenomeAltera', 
                    cep = '$cepAltera', 
                    endereco = '$enderecoAltera', 
                    numero = '$NumAltera', 
                    complemento = '$complementoAltera', 
                    bairro = '$bairroAltera', 
                    fone = '$FoneAltera', 
                    fax = '$FaxAltera' 
                WHERE email = '$emailAltera' 
                AND  
                status = 1";
        $rowsUpdateFisica = $db->execute($sql);

        return $rowsUpdateFisica;
    }

    public function updateUsuarioJuridica($nomeFatasiaAltera, $RamoAltera, $numeroFiliais, $cepAltera, $enderecoAltera, $NumAltera, $complementoAltera, $bairroAltera, $FoneAltera, $FaxAltera, $emailAltera) {
        global $db;

        $sql = "UPDATE site_pessoa_juridica
                SET nomefantasia = '$nomeFatasiaAltera',
                    ramoatividade = '$RamoAltera',
                    numerofiliais = '$numeroFiliais',
                    cep = '$cepAltera',
                    endereco = '$enderecoAltera',
                    numero = '$NumAltera',
                    complemento = '$complementoAltera',
                    bairro = '$bairroAltera',
                    fone = '$FoneAltera',
                    fax = '$FaxAltera'
                WHERE email = '$emailAltera'
                AND 
                status = 1";
        $rowsUpdateJuridica = $db->execute($sql);

        return $rowsUpdateJuridica;
    }

}

?>
