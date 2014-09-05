<?php
include("../app.php");
include("../inc/inc.restrict.php");
include("../inc/inc.menu.php");
$load->system("functions/date.php");
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">
    <head>
        <?php $system->getFaviconHeader(); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo strip_tags($cfg["system_title"]); ?></title>
        <style>
            @import "../inc/default.css";
            @import "../inc/calendario/calendario.css";
            @import "../inc/htmleditor/htmleditor.css";
            @import "../inc/colorpicker/colorpicker.css";
            @import "../inc/multiupload/multiUpload.css";
        </style>
        <script src="../../_system/js/jquery.js"></script>
        <script src="../../_system/js/default.js"></script>
        <script src="../../_system/js/form.js"></script>
        <script src="../../_system/js/ajax.js"></script>
        <script src="../../_system/js/popup.js"></script>
        <script src="../inc/routines.js"></script>
        <script src="../inc/menu.js"></script>
        <script src="../inc/calendario/calendario.js"></script>
        <script src="../inc/htmleditor/htmleditor.js"></script>
        <script src="../inc/colorpicker/colorpicker.js"></script>
        <script src="../inc/tree/FieldTree.js"></script>
        <script src="../inc/multiupload/swfobject.js"></script>
        <script src="../inc/multiupload/multiUpload.js"></script>
        <script>
            var menu = '<?php echo $input->request("menu"); ?>';
            var routine;
            var tmp_id;
            var id;
            var delete_enabled = true;
            var rnd = 1;
            var submit_permission = true;
            var htmleditor1, htmleditor2, htmleditor3, htmleditor4, htmleditor5;
            var uploader = new multiUpload('uploader', 'uploader_files');
        </script>
    </head>
    <body class="bg">
        <iframe name="ifr_aux" id="ifr_aux" style="display: none;"></iframe>
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td>
                    <table class="box" cellspacing="0" cellpadding="0" border="0" style="border:0px;">
                        <tr>
                            <td align="left" valign="middle" width="130">
                                <table cellspacing="0" cellpadding="0" align="left" width="200">
                                    <tr>
                                        <td><div class="left">&nbsp;</div></td>
                                        <td class="center">
                                            <img src="../../_config/<?php echo $cfg["system_logo"]; ?>" alt="<?php echo $cfg["system_title"]; ?>" title="<?php echo $cfg["system_title"]; ?>" />
                                        </td>
                                        <td><div class="right">&nbsp;</div></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="left" valign="top">
                                <table cellspacing="0" cellpadding="0" class="tblMenu">
                                    <tr><?php echo $menu->loadMenu(); ?></tr>
                                </table>
                            </td>
                            <td valign="top"><div style="background:url(../img/bg_top.jpg) top left no-repeat;width:8px;height:103px;">&nbsp;</div></td>
                            <td style="padding-left:12px;" valign="top" width="190">
                                <table cellspacing="2" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding-top:20px;">
                                            <span style="font-weight:bold; color: #6BB8F5; ">Bom dia, <?php echo $profile->fields("usuario"); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo (weekDayBrName(date("w")) . ", " . date("d") . " de " . monthToBrName(date("m")) . " de " . date("Y")); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            IP: <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="padding-top:5px;">
                                            <?php
                                            if (filesize(DIR_ROOT . "_config/exceptions/home.php") > 100) {
                                                ?><a href="?" title="Ir para home"><img style='margin-right: 5px;' width='89' height='29' src="../img/icons/home.gif" alt="Home"></a><?php
                                        }
                                            ?>
                                            <a href="system/routines.php?routine=logout" title="Clique aqui para sair"><img width='89' height='29' src="../img/buttons/sair.jpg" alt="Sair"></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>		
                </td>
            </tr>
            <?php
            $subs = $menu->loadSubs();

            if ($subs != "") {
                ?>
                <tr>
                    <td>
                        <table class="box" cellspacing="0" cellpadding="0" style="border-collapse:collapse; padding: 0 0 0 0px; border:0px;">
                            <tr>
                                <td style="border:0px;">
                                    <?php echo $subs ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>
                    <table class="box" cellspacing="0" cellpadding="0" style="padding: 5px;">
                        <tr>
                            <td id="conteudo">
                        <center><div class="padding: 10px;">Carregando...</div></center>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php if (IS_DEVELOP) { ?>
    <div id="box_html" style="font-family: 'Courier New', Courier, monospace; font-size: 11px; border: 1px solid #777777; line-height: 10px; display: block;">

    </div>
<?php } ?>
<?php
//Page handling
$page = $menu->getInclude();

if (file_exists($page)) {
    ?><script>ajaxGet('<?php echo $page; ?>');</script><?php
} else {
    error(2, "Arquivo '" . $page . "' não existe.");
}
?>
</body>
</html>