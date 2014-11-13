<section id="featured-recipes">
    <div class="container">						
        <h1 class="page-title" style="width: 100%; text-align: center;">Acompanhe as <strong>Melhores receitas da Internet</strong> pra você!</h1>
        <div class="featured-recipes-slider">
            <div id="carousel-wrapper-feat-recipes" class="carousel-wrapper-feat-recipes">
                <div id="carousel-feat-recipes">
                    <?php
                    //for($i = 0; $i < 6; $i++){
                    foreach ($recipes as $r) {
                        ?>
                        <span id='<?php echo $r['id_receita']; ?>' class='feat-recipe-big-image'>
                            <img src="<?php echo base_url();?>assets/upload/recipe/<?php echo $r['foto']; ?>" alt=''/>
                            <div class="carousel-feat-recipes-shadow"></div>
                            <div class="feat-post-cuisine-box">
                                <div class="feat-post-cuisine-box-feat">
                                    Destaques
                                </div>
                                <div class="feat-post-cuisine-box-cuisine">
                                    <i class="fa fa-cutlery"></i>
                                    <div class="recipe-categories">
                                        <p><?php echo $r['nome_categoria'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="feat-post-black-box">
                                <div class="feat-post-black-box-content">
                                    <div class="feat-post-title"><a href="<?php echo base_url().'receita/interna/'.$r['id_receita']?>"><?php echo $r['nome'] ?></a></div>
                                    <div class="full"> <?php
                                        $word_limit = 50;
                                        $string = $r['observacao'];
                                        $words = explode(' ', $string);
                                        $resultado = implode(' ', array_slice($words, 0, $word_limit));

                                        echo $resultado;
                                        ?>  
                                    </div>
                                    <div class="arrow-right-feat"> </div>
                                </div>
                                <div class="recipe-author-header">
                                    <div class="recipe-author-image">
                                        <img class='author-avatar' src="<?php echo base_url();?>assets/upload/author/<?php echo $r['foto_user']; ?>" alt='' /></div>
                                    <div class="recipe-author-name">
                                        <a href="<?php echo base_url().'perfil/interna/'.$r['id_usuario']?>" title="<?php echo $r['nome_user'];?>" rel="author">
                                            <?php echo $r['nome_user'] ?>
                                        </a>
                                    </div>
                                    <div class="recipe-author-bg-stripe">
                                    </div>
                                </div>
                            </div>
                        </span>
                        <?php
                    }
                    ?>

                </div>

            </div>

            <div id="thumbs-wrapper-feat-recipes">
                <div id="thumbs-feat-recipes">
                    <?php
                    for ($i = 0; $i < count($recipes); $i++) {
                        ?>
                        <a href="#<?php echo $recipes[$i]['id_receita'] ;?>">
                            <span class='image-thin-border'>
                                <span class='image-big-border'>
                                    <span class='image-small-border'>
                                        <img src="<?php echo base_url();?>assets/upload/recipe/<?php echo $recipes[$i]['foto']; ?>"/>
                                    </span>
                                </span>
                            </span>
                            <span class='feat-recipe-thumb-title'><?php echo $recipes[$i]['nome']; ?></span>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <a id="prev" href="#"><i class="fa fa-angle-up"></i></a>
                <a id="next" href="#"><i class="fa fa-angle-down"></i></a>
            </div>
        </div>
        <div class="recipe-search-widget-container">
        </div>
    </div>
</section>