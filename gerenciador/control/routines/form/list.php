<?php
include_once("../../app.php");
include("../../inc/inc.restrict.php");
include("../../inc/inc.menu.php");

global $routine;
global $form;

$output->ajaxHeader();

$sub = $menu->getSub();
$load->config("forms/Form" . ucfirst($sub->class) . ".php");
$class = "Form" . $sub->class;
$form = new $class();

//if is a form only
if ($form->is_unique) {
    redir("form.php?menu=" . $input->request("menu") . "&routine=insert");
    die();
}

//headers
$routine = "O";
$headers = $form->getHeaders();

//filters
$routine = "F";
$filters = $form->getFilters();


//Reset fieldset for list
$routine = "L";
$form->resetFieldSet();


//procces query/page
$records_total = 0;
if (($filters["sql"] != "") || ($form->show_list_init)) {
    //.query
    $sql = $form->getListSql($filters["sql"], $headers["sql"]);

    $rs_list = $db->execute($sql);

    /*     * *****  INSERE O LOG  ******* */
    $log->insertLog("select");
    /*     * ***** / INSERE O LOG  ******* */

    //.page
    $page = $form->getListPage();
    $rs_list->pagesize = $form->page_size;
    $records_total = $rs_list->recordCount();

    if ($records_total > $form->page_size) {
	$rs_list->page($page);
    }
}

//execute routine of button(if request)
$old_routine = $routine;
$routine = $input->get("routine");
if ($routine == "list_button") {
    $form->execButton($input->get("name"));

    die();
}
$routine = $old_routine;

//load init of form and fields
$form->loadInitAll("L");

//display filters
if (($filters["sql"] == "") && (!$form->show_filters_init)) {
    $filters_display = "none";
    $filters_img = "";
} else {
    $filters_display = "";
    $filters_img = "_disabled";
}

if ((IS_LOCAL) && (IS_DEVELOP)) {
    ?><div style="text-align: center;"><a href="javascript: ajaxGet('<?php echo $_SERVER['PHP_SELF']; ?>');">refresh</a></div><br><?php
}

if ($input->session('id_register') != '') {
    ?>
    <script>
        listUpdate(<?php echo $input->session('id_register') ?>);
    </script>
    <?php
    $input->unsetSession('id_register');
}
?>
<script>
    delete_enabled = <?php echo ($form->testFlag("D")) ? "true" : "false"; ?>;
</script>

<?php
$form->onPreList();
?>

<div>
    <table cellspacing="0" cellpadding="0" width="968" height="16" border="0">
	<tr>
	    <td width='80' align="left">
		<?php if ($filters["html"] != "") { ?>
    		<a href="#" onClick="javascript: showHideFilters();" title="Mostrar/Esconder filtro(s)"><img id="img_filter" src="../img/buttons/filter<?php echo $filters_img; ?>.jpg"></a>
		<?php } ?>
	    </td>
	    <td width="120">
		<?php
		if ($records_total) {
		    ?>Listando <b><?php echo $records_total; ?></b> registro<?php
		if ($records_total > 1) {
			?>s<?php
	    }
	}
		?></td>
	    <td align="center">
		<?php
		if ((($filters["sql"] != "") || ($form->show_list_init)) && ($rs_list->recordCount() > 0) && ($rs_list->pagecount > 1)) {
		    ?>
    		<table cellpadding="0" cellspacing="0">
    		    <tr>
    			<td width="10" valign="middle">
				<?php if ($rs_list->absolutepage > 1) { ?>
				    <a href="#" onClick="javascript: listPage('<?php echo $rs_list->absolutepage - 1 ?>');" title="Página anterior">Anterior</a>
				<?php } ?>
    			</td>
    			<td style="padding: 0 10 0 10px;" align="center">
				<?php
				$pagecount = $rs_list->pagecount;
				$pagina = $rs_list->absolutepage;
				$maximo = 10;
				$inicial = 1;

				if ($pagecount > $maximo) {
				    $meio = ceil($maximo / 2);
				    if ($pagina > $meio) {
					$inicial = $pagina - $meio;
				    }
				    $min = $pagecount - $maximo;
				    if ($inicial > $min) {
					$inicial = $min + 1;
				    }
				}
				$x = $inicial;
				$counter = 0;
				while (($x <= $pagecount) && ($counter < $maximo)) {
				    if ($pagina <> $x) {
					?><a href="javascript: listPage('<?php echo $x; ?>')" class="link"><?php echo $x; ?></a><?php
			} else {
					?><b><?php echo $x; ?></b><?php
			}
			$x++;
			$counter++;

			if (($x <= $pagecount) && ($counter < $maximo)) {
					?> | <?php
			}
		    }
				?>
    			</td>
    			<td width="10" valign="middle">
				<?php if ($rs_list->absolutepage < $rs_list->pagecount) { ?>
				    <a href="#" onClick="javascript: listPage('<?php echo $rs_list->absolutepage + 1; ?>');" title="Próxima página">Próximo</a>
				<?php } ?>
    			</td>
    		    </tr>
    		</table>
		    <?php
		}
		?>
	    </td>
	    <td width="250" align="right" height="16" id="button_bar">
		<?php
		foreach ($form->_buttons as $v) {
		    $title = "";
		    if ($v["label"] != "") {
			$title = "title=\"" . $v["label"] . "\"";
		    }
		    ?><a <?php echo $title; ?> href="javascript: nothing_func();" onclick="javascript: listButton('<?php echo $v["name"]; ?>'); "><img src="../../_config/images/<?php echo $v["name"] ?>.gif" style="margin-bottom: 2px; margin-right: 5px;" /></a><?php
	    }
		?>
		<?php if ($form->testFlag("I")) { ?>
    		<a href="javascript: listInsert();" title="Inserir registro"><img src="../img/buttons/add.jpg" alt="Inserir"></a>
		<?php } ?>
	    </td>
	</tr>
    </table>
</div>
<div id="div_filtros" class="sep" style="display: <?php echo $filters_display; ?>">
    <form id="frm_filters" name="frm_filters" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<table cellpadding="0" cellspacing="0" width="968">
	    <tr>
		<td width="150" valign="top" align="left" style="padding: 10px;">
		    Filtros
		</td>
	    <input type="hidden" name="sql" value="<?php echo base64_encode($sql); ?>" />
	    <input type="hidden" name="menu" value="<?php echo $input->request("menu"); ?>" />
	    <input type="hidden" name="page" id="input_page" value="<?php echo $page; ?>" />
	    <input type="hidden" name="order" id="input_order" value="<?php echo $input->post("order"); ?>" />
	    <input type="hidden" name="sem_filtro" id="input_sem_filtro" value="0" />
	    <input type="hidden" name="extra" id="input_extra" value="" />
	    <td align="center">
		<table cellpadding="0" cellspacing="2" width="100%">
		    <?php echo $filters["html"]; ?>
		</table>
		<script>
		    f.maskFields();
		</script>
		<br />
		<input type="image" src="../img/buttons/filter_submit.jpg" onclick="javascript: { preListSubmitFilters(); }" title="Filtrar" alt="Filtrar" />
		<?php if ($filters["sql"] != "") { ?>
    		<input type="image" src="../img/buttons/filter_clean.jpg" onclick="javascript: { document.getElementById('input_sem_filtro').value = '1'; listSubmitFilters(); }" title="Sem filtro" alt="Sem filtro" />
		<?php } ?>
		<br /><br />
	    </td>
	    </tr>
	</table>
    </form>
</div>
<div class="sep">
    <form id="frm_list" name="frm_list" action="form/routines.php?menu=<?php echo $input->request("menu"); ?>&routine=delete_checks" method="post">
	<table cellpadding="0" cellspacing="1" width="968" class="listagem">
	    <?php if (($filters["sql"] != "") || ($form->show_list_init)) { ?>
    	    <thead>
    		<tr>
			<?php if ($form->testFlag("D")) { ?>
			    <td class="header_cinza" width="30"><input id="chk_todos" type="checkbox" onClick="javascript: check(this); "></td>
			<?php } ?>
			<?php echo $headers["html"]; ?>
    		</tr>
    	    </thead>
    	    <tbody>
		    <?php
		    if (!$rs_list->EOF) {
			$css = 2;
			$i = 1;

			$fields = $form->getFieldSet();

			while (!$rs_list->EOF) {
			    $css = 3 - $css;

			    echo "<tr id='tr_" . $i . "' onmouseover=\"javascript: listOverOut('over', '" . $i . "');\" onmouseout=\"javascript: listOverOut('out', '" . $i . "');\">" . CRLF;

			    $extra = "class='td" . $css . "' ";
			    if ($form->testFlag("U")) {
				$extra .= "onclick=\"javascript: listUpdate('" . $rs_list->fields($form->key_field) . "');\"";
			    } else {
				$extra .= "style=\"cursor: default;\"";
			    }

			    if ($form->testFlag("D")) {
				echo "	<td align='center'><input type='checkbox' name='chk_" . $i . "' id='chk_" . $i . "' value='" . $rs_list->fields($form->key_field) . "' onclick=\"javascript: { checkMostrar(); listOverOut('over', '" . $i . "'); }\"></td>" . CRLF;
			    }

			    $form->setValuesFromRs($rs_list);

			    foreach ($fields as $k => $v) {
				if ($v->testFlag("L")) {
				    $v->value = $rs_list->fields($v->name);
				    $v->is_formated = false;

				    echo "	" . trim($v->getHtmlList($extra)) . LF;
				}
			    }

			    echo "</tr>";

			    $rs_list->moveNext();
			    $i++;
			}
		    } else {
			?><tr><td colspan="100%" align="center" style="height: 40px; background: #BBE2FF;"><strong style="color: #ffffff;">Nenhum registro encontrado</strong></td></tr><?php
	    }
	}
		?>
	</table>
    </form>
</div>
<div class="sep" id="div_botao_excluir" style="display: none;">
    <a href="javascript: checkExcluir();" title="Excluir Selecionados"><img src="../img/buttons/delete_selected.jpg" alt="Excluir Selecionados" /></a>
</div>
<?php
$form->onPosList();
$debug->loadList();
?>