<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
$this->load->model('receita_model');
?>


<section id="page-title">

    <div class="container">

        <h1 class="page-title fn" itemprop="name">
            <?php echo $receita['nome']; ?>
        </h1>

        <div class="recipe-header-info-block">

            <i class="fa fa-cutlery"></i>

            <span class="recipe-categories">
                <p><?php echo $receita['nome_categoria']; ?></p>
            </span>

        </div>

    </div>

</section>

<section id="recipe-page">

    <div id="recipe-block" class="container">

        <div class="one_half first cbp-so-section">

            <div class="recipe-block">

                <div id="carousel-wrapper" class="carousel-wrapper">
                    <div class="carousel-shadow"></div>
                    <div id="carousel">


                        <span id='1'><img itemprop='photo' src='<?php echo base_url(); ?>assets/upload/recipe/<?php echo $receita['foto']; ?>' alt='' class='photo'  itemprop='thumbnailURL'></span><span id='146'><img src='../../wp-content/uploads/bfi_thumb/arugula-1-2wlu0fysxybkear035tkwa.jpg' alt=''/></span><span id='147'><img src='../../wp-content/uploads/bfi_thumb/arugula-2-2wlu0g7umjdxye8quw6w3u.jpg' alt=''/></span><span id='148'><img src='../../wp-content/uploads/bfi_thumb/arugula-32-2wlu0ggwb4gbihqhmmk7be.jpg' alt=''/></span><span id='149'><img src='../../wp-content/uploads/bfi_thumb/arugula-4-2wlu0gugu01vumz3s8464q.jpg' alt=''/></span><span id='150'><img src='../../wp-content/uploads/bfi_thumb/arugula-5-2wlu0gyzoal2mopz63atqi.jpg' alt=''/></span>						</div>
                </div>
            </div>

        </div>

        <div class="one_half cbp-so-section">

            <div class="recipe-block">

                <div class="one_half first">

                    <ul class="dish-menu-info-odd">

                        <li class="comments-info"><span class="recipe-icon-comments"><i class="fa fa-comment-o"></i></span> <span class="recipe-info-title">Comments:</span> <span class="dish-menu-info-description"><span class="dsq-postid" rel="152 http://alexgurghis.com/themes/wpcook/recipes/american-arugula-salad/">1</span></span></li>

                    </ul>

                </div>

                <div class="one_half">

                    <div class="recipe-author-header">

                        <div class="recipe-author-image">

                            <img class='author-avatar' src='<?php echo base_url(); ?>assets/upload/author/<?php echo $receita['foto_user']; ?>' alt='' />							</div>

                        <div class="recipe-author-name" itemprop="author">
                            <a href="<?php echo site_url('perfil/interna/' . $receita['id_usuario']); ?>" title="Posts by William Marz" rel="author">William Marz</a>							</div>

                        <div class="recipe-author-bg-stripe"></div>
                    </div>

                    <div class="author-description">
                        <p><a href="../../author/william/index.html">Ver Perfil</a></p>

                    </div>

                </div>
                <?php
                /*
                  <div class="recipe-ratings"><span class="rating-title">Recipe Rating:</span><div id="post-ratings-152" class="post-ratings" itemscope itemtype="http://schema.org/Article" data-nonce="fa24a88b73"><img id="rating_152_1" src="../../wp-content/plugins/wp-postratings/images/stars/rating_on.png" alt="1 Star" title="1 Star" onmouseover="current_rating(152, 1, '1 Star');" onmouseout="ratings_off(3.5, 4, 0);" onclick="rate_post();" onkeypress="rate_post();" style="cursor: pointer; border: 0px;" /><img id="rating_152_2" src="../../wp-content/plugins/wp-postratings/images/stars/rating_on.png" alt="2 Stars" title="2 Stars" onmouseover="current_rating(152, 2, '2 Stars');" onmouseout="ratings_off(3.5, 4, 0);" onclick="rate_post();" onkeypress="rate_post();" style="cursor: pointer; border: 0px;" /><img id="rating_152_3" src="../../wp-content/plugins/wp-postratings/images/stars/rating_on.png" alt="3 Stars" title="3 Stars" onmouseover="current_rating(152, 3, '3 Stars');" onmouseout="ratings_off(3.5, 4, 0);" onclick="rate_post();" onkeypress="rate_post();" style="cursor: pointer; border: 0px;" /><img id="rating_152_4" src="../../wp-content/plugins/wp-postratings/images/stars/rating_half.png" alt="4 Stars" title="4 Stars" onmouseover="current_rating(152, 4, '4 Stars');" onmouseout="ratings_off(3.5, 4, 0);" onclick="rate_post();" onkeypress="rate_post();" style="cursor: pointer; border: 0px;" /><img id="rating_152_5" src="../../wp-content/plugins/wp-postratings/images/stars/rating_off.png" alt="5 Stars" title="5 Stars" onmouseover="current_rating(152, 5, '5 Stars');" onmouseout="ratings_off(3.5, 4, 0);" onclick="rate_post();" onkeypress="rate_post();" style="cursor: pointer; border: 0px;" /><meta itemprop="name" content="American Arugula Salad" /><meta itemprop="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut ..." /><meta itemprop="url" content="index.html" /><div style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><meta itemprop="bestRating" content="5" /><meta itemprop="ratingValue" content="3.5" /><meta itemprop="ratingCount" content="2" /></div></div>
                  <div id="post-ratings-152-loading"  class="post-ratings-loading"><img src="../../wp-content/plugins/wp-postratings/images/loading.gif" width="16" height="16" alt="Loading ..." title="Loading ..." class="post-ratings-image" />&nbsp;Loading ...</div>
                  </div>
                 */
                ?>
            </div>

        </div>
        <div style="width:100%;float:left;">
            <div class="one_half first">

                <div class="recipe-block cbp-so-section">

                    <div class="recipe-page-title">

                        <i class="fa fa-file-text-o"></i>Ingredientes
                    </div>

                    <span class="recipe-desc-block">
                        <p>
                            <?php echo $receita['ingredientes']; ?>
                        </p>
                    </span>

                    <ul class="links">

                        <li>
                            Share recipe:						
                        </li>

                        <li class="service-links-pinterest-button">
                            <a href="http://www.pinterest.com/pin/create/button/?url=http://alexgurghis.com/themes/wpcook/recipe/american-arugula-salad/&amp;media=&amp;description=American%20Arugula%20Salad" data-pin-do="buttonPin" data-pin-config="beside"><img src="../../../../../assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
                            <script type="text/javascript" async src="../../../../../assets.pinterest.com/js/pinit.js"></script>
                        </li>

                        <li class="service-links-facebook-share">
                            <div id="fb-root"></div>
                            <script>(function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id))
                                        return;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "../../../../../connect.facebook.net/en_US/all.js#xfbml=1&appId=247363645312964";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-share-button" data-href="http://alexgurghis.com/themes/wpcook/recipe/american-arugula-salad/" data-type="button_count"></div>
                        </li>

                        <li class="service-links-google-plus-one last">
                            <!-- Place this tag where you want the share button to render. -->
                            <div class="g-plus" data-action="share" data-annotation="bubble"></div>

                            <!-- Place this tag after the last share tag. -->
                            <script type="text/javascript">
                                (function () {
                                    var po = document.createElement('script');
                                    po.type = 'text/javascript';
                                    po.async = true;
                                    po.src = '../../../../../apis.google.com/js/platform.js';
                                    var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(po, s);
                                })();
                            </script>
                        </li>

                        <li class="service-links-twitter-widget first">
                            <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1384205748.html#_=1384949257081&amp;count=horizontal&amp;counturl=http://alexgurghis.com/themes/wpcook/recipe/american-arugula-salad/&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http://alexgurghis.com/themes/wpcook/recipe/american-arugula-salad/&amp;size=m&amp;text=American Arugula Salad&amp;url=http://alexgurghis.com/themes/wpcook/recipe/american-arugula-salad/&amp;via=drupads" class="twitter-share-button service-links-twitter-widget twitter-tweet-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 107px; height: 20px;"></iframe>
                        </li>
                    </ul>

                </div>

            </div>

            <div class="one_half alignright">

                <div class="recipe-block" style="padding-bottom: 25px;">


                    <div class="recipe-page-title">

                        <i class="fa fa-list-ol"></i>Modo de Preparo
                    </div>


                    <span class="recipe-desc-block">
                        <p>
                            <?php echo $receita['modo_preparo']; ?>
                        </p>
                    </span>


                </div>

            </div>
        </div>

    </div>

</section>

<?php
$this->load->view("includes/footer.php");
?>	