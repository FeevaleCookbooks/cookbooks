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
            <a class="current" href="#">Meet Our To Chefs</a>
        </li>
    </ul>

    <div class="container pane">

        <div class="full" style="margin-bottom: 0;">



                    <?php
                    for($i=0;$i<8;$i++){
                        $class = '';
                        if($i == 4 || $i == 0)
                            $class = "first";
                    ?>

            <div class="one_fourth <?php echo $class ;?> author-block-home">

                <div class="author-block-home-bg">


                    <img src='assets/upload/author/teste2.jpg' alt=''/>
                </div>

                <div class="author-block-home-border"></div>

                <div class="author-block-home-content">

                    <div class="author-list-avatar">

                        <div class="recipe-author-image">


                            <img class='author-avatar' src='assets/upload/author/teste.jpg' alt='' />
                        </div>

                    </div>

                    <div class="author-list-name">
                        Helen Whiteman							</div>

                    <div class="author-list-total-posts">
                        Wrote 8 recipes and the latest is <a href='recipe/grilled-chicken-drumsticks/index.html'>Grilled Chicken Drumsticks</a>
                    </div>

                    <div class="author-list-link-profile">
                        <a href="author/helen/index.html"><i class="fa fa-user"></i>View Profile</a>
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