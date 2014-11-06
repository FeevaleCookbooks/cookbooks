<section id="homepage" style="padding-bottom: 0; padding-top: 40px;">
    <div class="container">
        <ul class="tabs container">
            <li >
                <a class="current" href="#">Ultimas Receitas</a>
            </li>
        </ul>
        <div class="pane container">
            <?php
            
            if(isset($receitas) && is_array($receitas)) {
                
            for ($i = 0; $i < count($receitas); $i++) {
                $class = '';
                if ($i == 4 || $i == 0) {
                    $class = "first";
                }
            ?>
                <a class="author-recipe-block <?php echo $class; ?>" href="">
                    <span class="block-recipe-image">
                        <img src="assets/upload/recipe/<?php echo $receitas[$i]['id_receita'].'.jpg' ?>" alt=''/>
                    </span>
                    <span class="block-recipe-border"></span>	
                    <span class="block-recipe-info-box">
                        <span class="block-recipe-info-image">
                            <img class='author-avatar' src="assets/upload/author/<?php echo $receitas[$i]['id_usuario'].'.jpg';?>"/>
                        </span>
                        <span class="block-recipe-info-title"><?php echo $receitas[$i]['nome_user'] ?></span>
                    </span>
                    <span class="block-recipe-info-hover">
                        <span class="block-recipe-info-hover-title"><?php echo $receitas[$i]['nome'] ?></span>
                        <span class="block-recipe-info-hover-link"><span>Conheça a receita</span></span>
                    </span>
                </a>
            <?php
            }
            } else {
                echo "Nenhuma receita encontrada";
            }
            ?>
        </div>
    </div>
</section>