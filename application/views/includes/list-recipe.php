<section id="homepage" style="padding-bottom: 0; padding-top: 40px;">
    <div class="container">
        <ul class="tabs container">
            <li >
                <a class="current" href="#">Ultimas Receitas</a>
            </li>
        </ul>
        <div class="pane container">
            <?php
            for ($i = 0; $i < 8; $i++) {
                $class = '';
                if ($i == 4 || $i == 0) {
                    $class = "first";
                }
            ?>
                <a class="author-recipe-block <?php echo $class; ?>" href="">
                    <span class="block-recipe-image">
                        <img src='assets/upload/recipe/teste.jpg' alt=''/>
                    </span>
                    <span class="block-recipe-border"></span>	
                    <span class="block-recipe-info-box">
                        <span class="block-recipe-info-image">
                            <img class='author-avatar' src='assets/upload/author/teste.jpg' alt='' />
                        </span>
                        <span class="block-recipe-info-title">Nome do Chef</span>
                        <span class="block-recipe-info-details">
                            <i class="fa fa-clock-o"></i>
                            60 min
                            <i class="fa fa-users"></i>
                            5 pessoas
                            <i class="fa fa-flask"></i>
                            Fácil
                        </span>
                    </span>
                    <span class="block-recipe-info-hover">
                        <span class="block-recipe-info-hover-title">Nome da receita</span>
                        <span class="block-recipe-info-hover-link"><span>Conheça a receita</span></span>
                        <span class="block-recipe-info-details">
                            <i class="fa fa-clock-o"></i>
                            60 min
                            <i class="fa fa-users"></i>
                            5 pessoas
                            <i class="fa fa-flask"></i>
                            Fácil
                        </span>
                    </span>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</section>