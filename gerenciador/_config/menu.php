<?php

global $menu;
global $profile;

$subs = array();
if ($profile->checkMenu(3)) {
    $subs[] = new Menu_sub("AssinantesJuridica", "Assinaturas Juridicas");
}
if ($profile->checkMenu(4)) {
    $subs[] = new Menu_sub("AssinantesFisica", "Assinaturas Fisicas");
}

if ($profile->checkMenu(5)) {
    $subs[] = new Menu_sub("Materia", "Materias");
}
if ($profile->checkMenu(6)) {
    $subs[] = new Menu_sub("MateriaRelacionada", "Materias Relacionadas");
}
if ($profile->checkMenu(7)) {
    $subs[] = new Menu_sub("Artigos", "Artigos Científicos");
}
if ($profile->checkMenu(8)) {
    $subs[] = new Menu_sub("ArtigosTecnicos", "Artigos Técnicos");
}
if ($profile->checkMenu(9)) {
    $subs[] = new Menu_sub("NormasArtigos", "Normas Artigos");
}
if ($profile->checkMenu(10)) {
    $subs[] = new Menu_sub("Anuncie", "Valores Anuncio");
}
if ($profile->checkMenu(11)) {
    $subs[] = new Menu_sub("BannerTopo", "Banner Topo");
}
if ($profile->checkMenu(12)) {
    $subs[] = new Menu_sub("DestaqueHome", "Destaque Home");
}
if ($profile->checkMenu(12)) {
    $subs[] = new Menu_sub("Assinatura", "Contrato");
}
if ($profile->checkMenu(17)) {
    $subs[] = new Menu_sub("Anunciante", "Anunciantes");
}
if ($profile->checkMenu(17)) {
    $subs[] = new Menu_sub("Ancora", "Ancora");
}
if (count($subs) > 0) {
    $menu->add("SITE", $subs, "images/site.png");
}

$subs = array();
if ($profile->checkMenu(1)) {
    $subs[] = new Menu_sub("adminUsuario", "Usuários");
}
if ($profile->fields('id') == 1) {
    $subs[] = new Menu_sub("adminSessao", "Sessões Manager");
}
if ($profile->checkMenu(2)) {
    $subs[] = new Menu_sub("adminLogManager", "Log Manager");
}
if ($profile->checkMenu(3)) {
    $subs[] = new Menu_sub("adminLogProjeto", "Log Projetos");
}
if ($profile->checkMenu(4)) {
    $subs[] = new Menu_sub("AdminIps", "Segurança");
}

if (count($subs) > 0) {
    $menu->add("CONFIG", $subs, "images/config.png");
}
?>