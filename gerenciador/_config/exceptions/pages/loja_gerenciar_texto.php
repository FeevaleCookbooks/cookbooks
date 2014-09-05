<?php
$cfg["database_connect"] = false;
include("../../../control/app.php");
include("../../../control/inc/inc.restrict.php");
$load->system("functions/text.php");
$load->system("library/XmlToArray.php");
$load->system("library/Xml.php");

$output->ajaxHeader();

// Seleciona a pasta onde fica o xml
$pasta = "../../../loja/inc/language/";

// Dá permissão na pasta, se o servidor permitir :P
@chmod($pasta,0777);

// Coloca em um array as linguas setadas no config
$arr_linguas = array();
for ($x=1;$x < 7;$x++) {
	if (isset($cfg['language'.$x])) {
		$arr_linguas[] = $cfg['language'.$x];
	} else {
		$x=8;	
	}
}

// Verifica a rotina (inserir, alterar, nenhuma rotina)
$routine = $input->get("routine");

// Busca os dados dos XML e coloca em array
foreach($arr_linguas as $valor) {
	if (file_exists($pasta.$valor.'.xml')) {
		$arquivo = $file->readFile($pasta.$valor.'.xml');
	} else {
		$file->copyFile($pasta.$arr_linguas[0].'.xml',$pasta.$valor.'.xml');
		$arquivo = $file->readFile($pasta.$valor.'.xml');
	}
	
	$xml_content = new XmlToArray($arquivo);
	$arr_tmp_content = $xml_content->createArray();
	
	$arr_content[$valor] = $arr_tmp_content['content'];
}

if ($routine != '') {
	// Faz as rotinas em cada lingua
	foreach($arr_linguas as $lingua) {
		$xml = new Xml();
	
		$root = $xml->createNode("content");
		
		switch ($routine) {
			case "alterar":
					// Passa por todos os campos
					for($total=0;$total<$input->post('total');$total++) {
						// Verifica se o campo será excluido
						if ($input->post('chkExcluir'.$total) == '') { // Verifica se é para excluir o texto
							$node = $root->createNode(formatNameFile($input->post('label'.$total))); // Label
							$node->setValue(nl2br(htmlentities($input->post('content_'.$lingua.'_'.$total)))); // Value
							$root->appendChild($node); // Adiciona no XML
						}
					}
					
				break;
			case "inserir":
					// Insere os dados antigos no novo XML
					foreach($arr_content[$lingua] as $key=>$value) {
						$node = $root->createNode(formatNameFile($key)); // Label
						$node->setValue(nl2br($value)); // Value
						$root->appendChild($node); // Adiciona no XML
					}
				
					// Insere os dados novos no novo XML
					for($x=0;$x<5;$x++) {
						if ($input->post('label'.$x) != '') {
							$node = $root->createNode(formatNameFile($input->post('label'.$x))); // Label
							$node->setValue(nl2br(htmlentities($input->post('content_'. $lingua .'_'. $x)))); // Value
							$root->appendChild($node); // Adiciona no XML
						}
					}
			
				break;
		}
		
		$xml->appendChild($root);
		
		$xml->getXML(); // Gera o XML
		$xml->save($pasta.$lingua.'.xml'); // Grava o XML
	}
	
	redir($_SERVER['PHP_SELF']); // Recarrega a pagina para atualizar o conteudo
}

?>
<br />
<script>
// Envia o formulario via Ajax
htmleditor5 = function (frm) {
	if (f.send(frm, true)) {
		var a = new Ajax();
		a.onLoad = function () {
			document.getElementById('conteudo').innerHTML = this.html;
			
			debugHtml(this.html);
			
			this.runJS(this.html);
		}
		a.sendForm(frm);
		
		showLoading();
	}
}
</script>
	<div>
		<h2>INSERIR TEXTO</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?routine=inserir" name="frmTextosInserir" id="frmTextosInserir" method="post" onsubmit="return false;">
		<table cellpadding="0" cellspacing="3" width="100%">
			<tr>
				<td>LABEL</td>
				<?php
				// Mostra os idiomas (sigla) no topo da tabela
				foreach($arr_linguas as $valor) {
					?>
					<td><?php echo strtoupper($valor); ?></td>
					<?php
				}
				?>
			</tr>
			<?php
			// Adiciona 5 campos para inserir conteudo
			for($x=0; $x < 5;$x++) {
				?>
				<tr>
					<td valign="top" width="150"><input type="text" name="label<?php echo $x ?>" class="input" style="width:140px;"></td>
					<?php
					// Cria um campo textarea para cada idioma
					foreach($arr_linguas as $valor) {
						?>
						<td valign="top"><textarea name="content_<?php echo $valor ?>_<?php echo $x ?>" class="input" style="height:60px; width:100%;"></textarea></td>
						<?php
					}
					?>
				</tr>
				<?php
			}
			?>
			<tr>
				<td align="right" colspan="100%" height="60"><input type="image" src="../img/buttons/insert.jpg" onclick="javascript: htmleditor5('frmTextosInserir');" /></td>
			</tr>
		</table>
		</form>
		
		<h2>ALTERAR TEXTO</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?routine=alterar" name="frmTextosAlterar" id="frmTextosAlterar" method="post" onsubmit="return false;">
		<table cellpadding="4" cellspacing="0" width="100%">
			<tr>
				<td>LABEL</td>
				<?php
				// Mostra os idiomas (sigla) no topo da tabela
				foreach($arr_linguas as $valor) {
					?>
					<td><?php echo strtoupper($valor); ?></td>
					<?php
				}
				?>
			</tr>
			<?php
			$total = 0;
			// Percorre todo o array com o conteudo que foi pego dos XML.
			foreach($arr_content[$arr_linguas[0]] as $key=>$value) {
				?>
				<tr <?php echo (($total % 2 == 0)?'  style="background-color:#EEE;"':'') ?>>
					<td valign="top" width="150"><input type="hidden" name="label<?php echo $total ?>" value="<?php echo $key ?>" class="input" style="width:140px;"><?php echo $key ?></td>
					<?php
					// Coloca em cada coluna dentro do textarea o valor que cada idioma representa
					foreach($arr_linguas as $lingua) {
						?>
						<td valign="top"><textarea name="content_<?php echo $lingua ?>_<?php echo $total ?>" class="input" style="height:60px; width:100%;"><?php echo str_replace("<br />",chr(10),html_entity_decode(utf8_decode($arr_content[$lingua][$key]))) ?></textarea></td>
						<?php
					}
					?>
					<td width="30">
						<!-- Check para selecionar se o conteudo deve ser excluido, se tiver selecionado, o conteudo será excluido do XML -->
						<input type="checkbox" name="chkExcluir<?php echo $total ?>" id="chkExcluir<?php echo $total ?>" value="on">
					</td>
				</tr>
				<?php
				$total++;
			}
			?>
			<tr>
				<td align="right" colspan="100%" height="60"><input type="image" src="../img/buttons/update.jpg" onclick="javascript: htmleditor5('frmTextosAlterar');" /></td>
			</tr>
		</table>
		<!-- Valor total de itens no XML, para facilitar o processo de alteração -->
		<input type="hidden" name="total" value="<?php echo $total ?>">
		</form>
		
</div>