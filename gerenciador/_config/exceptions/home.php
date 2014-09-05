<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	ini_set('display_startup_errors','On');
	include_once("../../control/app.php");
	include_once("../../control/inc/inc.restrict.php");
	$output->ajaxHeader();
?>
<center>
<br><br>
<div>
	Você pode alterar a senha de acesso ao gerenciador pelo formulário abaixo.
</div>
<br />
<table cellpadding="0" cellspacing="0">
	<tr>
		<td width="70" valign="top">
			<img src="../img/icons/usuario.jpg" alt="Alterar senha" />
		</td>
		<td>
			<form id="frm_form" name="frm_form" action="system/routines.php?routine=alterarsenha" method="post" onSubmit="return false;" autocomplete="off">
				<div>
					ALTERAR A SENHA DE ACESSO
				</div>
				<div style="margin-top:5px;margin-bottom:5px;">
					<input type="password" name="novasenha" id="Senha_PW01" class="input" style="width:150px;" />
				</div>
				<div align="right">
					<input type="image" src="../img/buttons/update.jpg" value="Login" onClick="javascript: formSubmit();" /><br /><br />
				</div>
				<?php 
					if ($input->session('session_retorno') != '') {
				?>
					<div>
						<font color="##009900"><?php echo($input->session('session_retorno')); ?></font>
					</div>
					<?php
					$input->unsetSession('session_retorno');
				}
				?>
			</form>
		</td>
	</tr>
</table>
<br /><br />
</center>