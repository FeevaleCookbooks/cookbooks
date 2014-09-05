<?php
include("../../app.php");
include("../../inc/inc.restrict.php");
include("../../inc/inc.menu.php");


global $routine;
global $form;
global $tmp_id;

$output->ajaxHeader();

//form class
$sub = $menu->getSub();
$load->config("forms/Form" . ucfirst($sub->class) . ".php");
$class = "Form" . $sub->class;
$form = new $class();

//routine
$routine = $input->get("routine");
if ($routine == "insert") {
	$button_img = "insert";
	$flag = "I";
	
	$tmp_id = (string)(rand(999999, 9999999) * 1000); //Random id for upload fields
} else {
	$form->fields[$form->key_field] = $input->get("id",false,'int');
	$form->select();

	/*******  INSERE O LOG  ********/
	$log->idregister = $form->fields($form->key_field);
	$log->insertLog("select");
	/******* / INSERE O LOG  ********/	
	
	$button_img = "update";
	$flag = "U";
}

//count for htmleditors fields
global $htmleditor_count;
$htmleditor_count = 1;


if ((IS_LOCAL) && (IS_DEVELOP)) {
	?><div style="text-align: center;"><a href="javascript: ajaxGet('<?php echo $_SERVER['PHP_SELF']; ?>?menu=<?php echo $_GET["menu"]; ?>&routine=<?php echo $_GET["routine"]; ?>&id=<?php echo $form->fields[$form->key_field]; ?>');">refresh</a></div><br><?php
}

$form->loadInitAll($flag);


?>
<script>
menu = '<?php echo $input->request("menu"); ?>';
routine = '<?php echo $routine; ?>';
tmp_id = '<?php echo $tmp_id; ?>';
id = '<?php echo $input->get("id",false,'int'); ?>';

customPrePost = function () {
	var ok = true;
	var routine = '<?php echo $routine; ?>';
	
	<?php echo $form->_loadJSPrePost($flag); ?>
	
	if (ok) {
		formSubmit();
	}
}
</script>
<div>
	<table cellspacing="0" cellpadding="0" width="968" height="16">
		<tr>
			<td align="left">
				Campos marcados com <font class="red">*</font> são obrigatórios.
			</td>
			<td width="150" align="right">
				<?php if (($routine == "update") && ($form->testFlag("D"))) { ?>
					<a href="javascript: { if (confirm('Deseja realmente excluir este item?')) { ajaxGet('form/routines.php?menu=<?php echo $input->request("menu"); ?>&routine=delete&id=<?php echo $form->fields[$form->key_field]; ?>'); } }" title="Excluir registro"><img src="../img/buttons/del.jpg" alt="Excluir"></a>
				<?php } ?>
			</td>
		</tr>
	</table>
</div>
<form id="frm_form" name="frm_form" action="form/routines.php?menu=<?php echo $input->request("menu"); ?>&routine=<?php echo $routine; ?>&id=<?php echo $form->fields["id"]; ?>" method="post" onsubmit="return false;">
<input type="hidden" name="tmp_id" value="<?php echo $tmp_id; ?>" />
<div class="form">
	<table cellspacing="0" cellpadding="0" width="100%" height="100%">
		<tr>
			<td width="49%" valign="top">
				<table cellspacing="3" cellpadding="0" width="100%">
						<?php
						$fields = $form->getFieldSet();
						
						foreach ($fields as $k => $v) {
							if ($v->testFlag($flag)) {
								echo $v->getHtml() . CRLF;
							}
						}
						?>
				</table>
			</td>
		</tr>
	</table>
</div>
<div class="sep">
	<div align="right">
		<?php
		$show = true;
		
		if (($routine == "update") && (!$form->enable_update)) {
			$show = false;
		}
		
		if ($show) {
			?>
			<input type="image" id="botoes" src="../img/buttons/<?php echo $button_img; ?>.jpg" onclick="javascript: prePost();">	
			<input type="image" src="../img/buttons/cancel.jpg" onclick="javascript: ajaxGet('form/list.php?menu=<?php echo $input->get("menu"); ?>');" />
			<?php
		} else {
			?>
			<input type="image" src="../img/buttons/back.jpg" onclick="javascript: ajaxGet('form/list.php?menu=<?php echo $input->get("menu"); ?>');" />
			<?php
		}
		?>		
	</div>
</div>
<script>
f.maskFields();
</script>
</form>
<?php
$debug->loadList();
?>