<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
?>
<section id="homepage" style="padding-bottom: 0; padding-top: 40px;">
    
    <?php
        foreach($receitas as $receita) {
    ?>
    <div class="container">
        <div class="pane container">
            <a class="author-recipe-block" href="receita/interna/<?php echo $receita->id_receita;?>">
                <span class="block-recipe-image">
                    <img src="<?php echo base_url();?>assets/upload/recipe/<?php echo $receita->foto;?>"/>
                </span>
                <span class="block-recipe-border"></span>	
                <span class="block-recipe-info-box">
                    <span class="block-recipe-info-title">Rafael Zorn</span>
                </span>
                <span class="block-recipe-info-hover">
                    <span class="block-recipe-info-hover-title"><?php echo $receita->nome;?></span>
                    <span class="block-recipe-info-hover-link"><span>Conheça a receita</span></span>
                </span>
            </a>
        </div>
    </div>

    <?php
        }
    ?>
</section>
<?php
$this->load->view("includes/footer.php");
?>  