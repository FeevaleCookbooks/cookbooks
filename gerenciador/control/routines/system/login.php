<?php
include("../../app.php");

if (file_exists(DIR_CONFIG . "exceptions/login.php")) {
    include(DIR_CONFIG . "exceptions/login.php");
    die();
}

$ip = getenv("REMOTE_ADDR");

$profile = new Profile();
$o_permission = $profile->getPermission($ip);
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">
    <head>
        <?php $system->getFaviconHeader("login"); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script src="../../../_system/js/default.js"></script>
        <script src="../../../_system/js/form.js"></script>
        <title><?php echo(strip_tags($cfg["system_title"])); ?></title>
        <style>
            @import "../../../_system/css/default.css";

            body { font-family: Tahoma; /*background: url(../../img/bg.gif)*/ top left repeat-x #F1F1F1; }
            table { font-family: Tahoma; font-size:11px; color: #658248; }
            a { font-family: Tahoma; font-size:11px; color: #658248; text-decoration: none; }

            .rodape {
                background: #CCCCCC;
            }
            .left {
                width:8px;
                height:103px;
                /*background: url(../../img/bg_left.jpg) top left no-repeat;*/
            }
            .right {
                width:8px;
                height:103px;
                /*background: url(../../img/bg_right.jpg) top left no-repeat;*/
            }
            .center {
                text-align:center;
                width:100px;
                height:103px;
                /*background: url(../../img/bg_center.jpg) top left repeat-x;*/
                padding-top:5px;
                padding-left:30px;
                padding-right:30px;
            }
            .tbl {
                margin-top:75px;
                background:#FFFFFF;
                border:1px solid #CCCCCC;
                width:360px;
                height:220px;
            }
            .tbl td {
                padding-left: 40px;
                padding-right: 40px;
            }
            .input {
                width:276px;
                height:24px;
                border-top:1px solid #808080;
                border-left:1px solid #808080;
                border-bottom:1px solid #D4D0C8;
                border-right:1px solid #D4D0C8;
            }
        </style>
    </head>
    <body>
        <table cellspacing="0" cellpadding="0" width="100%" height="100%" align="center">
            <tr height="99%">
                <td valign="top">
                    <table cellspacing="0" cellpadding="0" style="margin-left: 770px; margin-top: 200px; position: absolute;">
                        <tr>
                            <td><div class="left">&nbsp;</div></td>
                            <td class="center">
                                <img src="../../../_config/<?php echo($cfg["system_logo"]); ?>" alt="<?php echo($cfg["system_title"]); ?>" title="<?php echo($cfg["system_title"]); ?>" />
                            </td>
                            <td><div class="right">&nbsp;</div></td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" style="margin-left: 300px; margin-top: 100px;">
                        <tr>
                            <td>
                                <?php
                                if ($o_permission == true) {
                                    ?>
                                    <div id="divLogin">
                                        <form id="frm" name="frm" action="routines.php?routine=login" method="post" onSubmit="return false;" autocomplete="off">
                                            <table cellspacing="0" cellpadding="0" class="tbl" border="0">
                                                <tr>
                                                    <td style="padding-top:40px;">
                                                        <img src="../../img/usuario.gif" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="text" name="usuario" id="Usuário_TXT1" class="input"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <img src="../../img/senha.gif" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="password" name="senha" id="Senha_PW01" class="input" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-top:24px;">
                                                        <a href="javascript:hiddenShow('divLogin','divEsqueci');"><img src="../../img/buttons/esquecisenha.jpg" alt="Esqueci minha senha" border="0" /></a>
                                                    </td>
                                                    <td align="right" style="padding-bottom:30px;padding-top:24px;padding-left:0px;">
                                                        <input type="image" src="../../img/buttons/login.jpg" value="Login" onClick="javascript: f.send('frm');" /><Br><Br>
                                                        <?php
                                                        echo "Seu IP é: $ip";
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                    <div id="divEsqueci" style="display:none;">
                                        <form id="frmEsqueci" name="frmEsqueci" action="routines.php?routine=esqueciminhasenha" method="post" autocomplete="off">
                                            <table cellspacing="0" cellpadding="0" class="tbl" border="0">
                                                <tr>
                                                    <td style="padding-top:40px;" colspan="2" valign="top">
                                                        <img src="../../img/usuario.gif" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" valign="top">
                                                        <input type="text" name="usuariosenha" id="Usuário _TXT1" class="input"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-top:24px;">
                                                        <a href="javascript:hiddenShow('divEsqueci','divLogin');"><img src="../../img/buttons/voltar.jpg" alt="Voltar" border="0" /></a>
                                                    </td>
                                                    <td align="right" valign="top" style="padding-bottom:30px;padding-top:24px;padding-left:0px;">
                                                        <input type="image" src="../../img/buttons/enviar.jpg" value="Enviar" onClick="javascript: f.send('frmEsqueci');" /><Br><Br>
                                                        <?php
                                                        echo "Seu IP é: $ip";
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <table cellspacing="0" cellpadding="0" class="tbl" border="0">
                                        <tr>
                                            <td align="right" style="padding-bottom:30px;padding-top:24px;">
                                        <center>
                                            <img alt="Acesso Negado" src="../../img/acesso_negado.jpg"><br>
                                            <?php
                                            echo "Seu IP é: $ip";
                                            ?>
                                        </center>
                                </td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr class="rodape">
    <td>
        <table cellspacing="0" cellpadding="0" width="1000" height="30" align="center">
            <tr>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>
<script type="text/javascript">
    if(document.getElementById("Usuário_TXT1")) {document.getElementById("Usuário_TXT1").focus()};
</script>
<?php
if ($input->get("r") == 1) {
    ?>
    <script type="text/javascript">
        alert("Usuário/senha inválidos");
    </script>
    <?php
}

if ($input->session('session_retorno') != '') {
    ?>
    <script type="text/javascript">
        alert("<?php echo($input->session('session_retorno')) ?>");
    </script>
    <?php
    $input->unsetSession('session_retorno');
}
?>
</html>