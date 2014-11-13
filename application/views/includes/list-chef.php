<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section id="my-account" style="padding-top: 0;">

    <ul class="tabs container">
        <li >
            <a class="current" href="#">Encontre seus Chefs</a>
        </li>
    </ul>

    <div class="container pane">

        <div class="full" style="margin-bottom: 0;">



                    <?php

                    for($i=0;$i<count($chefs);$i++){
                        $class = '';
                        if($i == 4 || $i == 0)
                            $class = "first";
                    ?>

            <div class="one_fourth <?php echo $class ;?> author-block-home">

                <div class="author-block-home-bg">


                    <img src="<?php echo base_url();?>assets/upload/recipe/<?php echo $chefs[$i]['foto_receita']; ?>" alt=''/>
                </div>

                <div class="author-block-home-border"></div>

                <div class="author-block-home-content">

                    <div class="author-list-avatar">

                        <div class="recipe-author-image">


                            <img class='author-avatar' src="<?php echo base_url();?>assets/upload/author/<?php echo $chefs[$i]['foto']; ?>" alt='' />
                        </div>

                    </div>

                    <div class="author-list-name">
                        <?php echo $chefs[$i]['nome'];?>
                    </div>
                    <div class="author-list-link-profile">
                        <a href="<?php echo site_url('perfil/interna/'.$chefs[$i]['id_usuario']);?>"><i class="fa fa-user"></i>View Profile</a>
                    </div>

                </div>

            </div> 

                <?php
                }
                ?>
        </div> 

    </div>

</div>


</div>

</div>

</section>