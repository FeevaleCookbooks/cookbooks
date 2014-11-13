<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
?>
<section id="page-title">
    <div class="container">
        <h1 class="page-title">
            Perfil do chefe: <?= $dados_perfil[0]['nome']; ?>
        </h1>
    </div>
</section>
<section id="my-account">
    <div id="my-account-header" class="container">
        <div class="my-account-header">
            <div class="one_half first">
                <div class="my-account-author-header">
                    <div class="my-account-author-image">
                        <img class='author-avatar' src='<?php echo base_url();?>assets/upload/author/<?php echo $dados_perfil[0]['foto']; ?>' alt='' />						</div>
                    <div class="my-account-author-name">
                        <?= $dados_perfil[0]['nome']; ?>
                    </div>
                    <div class="my-account-author-url">
                        <span></span>
                    </div>
                    <div class="my-account-author-bg-stripe"></div>
                    <div class="my-account-author-description">
                        <p>Cidade: <?= $dados_perfil[0]['cidade'] ?></p>
                        <p>Profissão: <?= $dados_perfil[0]['profissao'] ?></p>
                        <p><?= $dados_perfil[0]['observacao']; ?></p>
                        <div class="my-account-stats-content" style="border: 0; background: none;">
                            <div class="one_half first" style="margin-bottom: 0;">
                                <span class="one_half first my-account-stats-number my-account-stats-recipes">
                                    <?php echo intval($dados_perfil[0]['quantidade_receitas']); ?>
                                </span>
                                <span class="one_half my-account-stats-info my-account-stats-recipes">
                                    Receitas<br />
                                    Publicadas<br />
                                    <i class="fa fa-cutlery"></i>
                                </span>
                                <span class="btn"><a href="<?php echo site_url("perfil/editar"); ?>">Editar Perfil</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php $this->load->view("includes/list-recipe.php"); ?>

<?php
$this->load->view("includes/footer.php");
?>	