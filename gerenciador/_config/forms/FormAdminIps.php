<?php

class FormAdminIps extends Form {

    function FormAdminIps() {
	parent::Form("admin_ip");
    }

    function configFields() {
	global $routine;

	$f = $this->newField("char", array("ipjunto", "IP"));
	$this->addField($f, "L");

	$f = $this->newField("char", array("descricao", "Descrição"));
	$f->maxlength = "100";
	$this->addField($f, "LOFIU");

	$f = $this->newField("char", array("ip1", "IP"));
	$f->maxlength = "3";
	$f->comment = "Utilize % como coringa.";
	$this->addField($f, "IU");

	$f = $this->newField("char", array("ip2", "IPr"));
	$f->maxlength = "3";
	$this->addField($f, "IU");

	$f = $this->newField("char", array("ip3", "IPr"));
	$f->maxlength = "3";
	$this->addField($f, "IU");

	$f = $this->newField("char", array("ip4", "IPr"));
	$f->maxlength = "3";
	$this->addField($f, "IU");

	$f = $this->newField("ativo", array('status', 'Ativo'));
	$f->value_initial = 1;
	$this->addField($f, "LOFIU");
    }

    function loadInit($rotina) {
	if ($rotina == "L") {
	    ?>
	    <script language="text/javascript">
	        jQuery(document).ready(function(){

	    	jQuery('.header:contains("Ativo")').text('Situação');

	        });
	    </script>
	    <?php

	}

	if ($rotina == "U" || $rotina == "I") {
	    ?>

	    <script language="text/javascript">
	        jQuery(document).ready(function(){

	    	jQuery('input[name*="ip"]').css('width', 30).css('margin-right', 5);
	    						
	    	jQuery('input[name="ip2"]').insertAfter('input[name="ip1"]');
	    	jQuery('input[name="ip3"]').insertAfter('input[name="ip2"]');
	    	jQuery('input[name="ip4"]').insertAfter('input[name="ip3"]');
	    	jQuery('.label:contains("IPr")').parent().remove();

	    	jQuery('input[name*="ip"]').keyup(function(event){

	    	    if (jQuery(this).val().length >= 3 || (event.shiftKey && event.which == 53) || (jQuery(this).val().length > 1 && (event.which == 190 || event.which == 194 || event.which == 9))) {
	    		jQuery(this).next().focus().select();
	    	    }
	    							
	    	    jQuery(this).val(jQuery(this).val().replace(".", ""));

	    	});

	    	jQuery('input[name*="ip"]').keydown(function(event){

	    	    if (!(((!(event.shiftKey || event.altKey) && event.which >= 48) && (!(event.shiftKey || event.altKey) && event.which <= 57)) || (event.which >= 96 && event.which <= 105) || event.which == 8 || (event.shiftKey && event.which == 53) || event.which == 190 || event.which == 194 || event.which == 9 )) {
	    		return false;
	    	    }

	    	    if (jQuery(this).val().length == 0 && event.which == 8) {
	    		jQuery(this).prev().focus().select();
	    	    } else if (jQuery(this).val() == '%' && event.which != 8) {
	    		jQuery(this).next().focus().select();
	    		return false;
	    	    } else if ((event.shiftKey && event.which == 53) && jQuery(this).val() != '') {
	    		return false;
	    	    }

	    	    if (event.shiftKey && event.which == 53) {
	    		jQuery(this).nextAll('input').val('%');
	    	    }

	    	});

	    	jQuery('font[color="#009900"]:contains("Ativo")').text('Liberado');
	    	jQuery('font[color="#009900"]:contains("Ativo")').text('Liberado');
	    	jQuery('.label:contains("Ativo")').html('Situação: <font class="red">*</font>');

	        });
	    </script>

	    <?php

	}
    }

    function getListSql($tmp_sql_filter, $tmp_sql_order) {
	return "select *, CONCAT(ip1,'.',ip2,'.',ip3,'.',ip4) as ipjunto from " . $this->table . " where 1=1 " . $tmp_sql_filter . " " . $tmp_sql_order;
    }

}
?>