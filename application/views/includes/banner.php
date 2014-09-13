
				<section id="featured-recipes">

					<div class="container">

						
						<h1 class="page-title" style="width: 100%; text-align: center;">Howdy! We have <strong>72 delicious recipes</strong> for you. Enjoy!</h1>

						<div class="featured-recipes-slider">

							<div id="carousel-wrapper-feat-recipes" class="carousel-wrapper-feat-recipes">
								
								<div id="carousel-feat-recipes">

									
									
																				
									
									<?php
									for ($i=0; $i < 6; $i++) { 
									?>
									<span id='<?php echo $i ;?>' class='feat-recipe-big-image'>
										<img src='assets/upload/recipe/banner.jpg' alt=''/>
										<div class="carousel-feat-recipes-shadow"></div>

										<div class="feat-post-cuisine-box">

											<div class="feat-post-cuisine-box-feat">Featured</div>

											<div class="feat-post-cuisine-box-cuisine">
												<i class="fa fa-cutlery"></i>

												<div class="recipe-categories">
													<p>Cuisines of the Americas</p>
													<p>Desserts</p>
												</div>

											</div>

										</div>

										<div class="feat-post-black-box">

											<div class="feat-post-black-box-content">

												<div class="feat-post-title"><a href="recipe/traditional-american-hot-dog/index.html">Traditional American Hot Dog</a></div>

												<div class="full">
													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis&hellip;											</div>

												<div class="feat-post-meta">

													
													<div class="feat-post-meta-item"><div class="recipe-icon-time"><i class="fa fa-clock-o"></i></div><div class="feat-post-meta-description">55 minutes</div></div>

													<div class="feat-post-meta-item"><div class="recipe-icon-portions"><i class="fa fa-users"></i></div><div class="feat-post-meta-description">6 persons</div></div>

													<div class="feat-post-meta-item"><div class="recipe-icon-difficulty"><i class="fa fa-flask"></i></div><div class="feat-post-meta-description">Difficult</div></div>

													<div class="feat-post-meta-item"><div class="recipe-icon-steps"><i class="fa fa-list-ol"></i></div><div class="feat-post-meta-description">5 steps</div></div>

												</div>

												<div class="arrow-right-feat"></div>

											</div>

											<div class="recipe-author-header">

												<div class="recipe-author-image">
																										
														<img class='author-avatar' src='assets/upload/author/teste.jpg' alt='' />											</div>

												<div class="recipe-author-name">
													<a href="author/michael/index.html" title="Posts by Michael Doe" rel="author">Michael Doe</a>											</div>

												<div class="recipe-author-bg-stripe"></div>

											</div>

										</div>

									</span>
									<?php
									}
									?>
									
									
																				
									
									    <script type="text/javascript">
								    // <![CDATA[
								        var disqus_shortname = 'alexgurghis';
								        (function () {
								            var nodes = document.getElementsByTagName('span');
								            for (var i = 0, url; i < nodes.length; i++) {
								                if (nodes[i].className.indexOf('dsq-postid') != -1) {
								                    nodes[i].parentNode.setAttribute('data-disqus-identifier', nodes[i].getAttribute('rel'));
								                    url = nodes[i].parentNode.href.split('#', 1);
								                    if (url.length == 1) { url = url[0]; }
								                    else { url = url[1]; }
								                    nodes[i].parentNode.href = url + '#disqus_thread';
								                }
								            }
								            var s = document.createElement('script'); s.async = true;
								            s.type = 'text/javascript';
								            s.src = '//' + 'disqus.com/forums/' + disqus_shortname + '/count.js';
								            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
								        }());
								    //]]>
								    </script>
											
									
								</div>

							</div>

							<div id="thumbs-wrapper-feat-recipes">
								<div id="thumbs-feat-recipes">

									
									
									<?php
									for ($i=0; $i < 6; $i++) {
									?>
									<a href='#<?php echo $i ;?>' class='selected'>
										<span class='image-thin-border'>
											<span class='image-big-border'>
												<span class='image-small-border'>
													<img src='assets/upload/recipe/teste2.jpg' />
												</span>
											</span>
										</span>
										<span class='feat-recipe-thumb-title'>Traditional American Hot Dog</span>
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

							<div class="recipe-search-stripe-border"></div>

							<div class="recipe-search-stripe-inner"></div>

							<div class="triangle-left"></div>

							<div class="triangle-right"></div>

							<div class="recipe-search-stripe-container">

								<div class="recipe-search-container">

									<div class="recipe-search-container-title">Find a recipe:</div>

									<div class="recipe-search-container-block">

										<form action="http://alexgurghis.com/themes/wpcook" method="get" id="search-recipes-form" accept-charset="UTF-8">

											<div class="recipe-search-keyword">

												<input placeholder="Keywords..." type="text" id="recipe-search-keyword" name="s" value="" size="30" class="form-text">

											</div>

											<div class="recipe-search-difficult">

												<select name="difficulty" id="difficulty" class="postform">
													<option selected disabled><i class="fa fa-flask"></i>Difficulty:</option>
													<option value="All">All</option>
													
													<option value="Easy">Easy</option>

													
													<option value="Medium">Medium</option>

													
													<option value="Difficult">Difficult</option>

																									</select>

											</div>

											<div class="recipe-search-cuisine">

												<select name="cuisine" id="cuisine" class="postform">
													<option selected disabled><i class="fa fa-cutlery"></i>Cuisine:</option>
													<option value="All">All</option>
													
													<option value="African cuisine">African cuisine</option>

													
													<option value="Asian cuisine">Asian cuisine</option>

													
													<option value="European cuisine">European cuisine</option>

													
													<option value="Oceanian cuisine">Oceanian cuisine</option>

													
													<option value="Cuisines of the Americas">Cuisines of the Americas</option>

																									</select>

											</div>

											<div class="recipe-search-category">

												<select name="cat" id="cat" class="postform">
													<option selected disabled><i class="fa fa-folder-o"></i>Category:</option>
													<option value="All">All</option>
													<option value='Breakfast &amp; Lunch'>Breakfast &amp; Lunch</option><option value='Barbeques'>Barbeques</option><option value='Entrees'>Entrees</option><option value='Cakes'>Cakes</option><option value='Appetizers'>Appetizers</option><option value='Drinks'>Drinks</option><option value='Salads'>Salads</option><option value='Desserts'>Desserts</option><option value='Main Dishes'>Main Dishes</option>												</select>

											</div>

											<div class="recipe-search-persons">

												<select name="persons" id="persons" class="postform">
													<option selected disabled><i class="fa fa-users"></i>Intended for:</option>
													<option value="All">All</option>

													
													<option value="1 person">1 person</option>

													
													<option value="2 persons">2 persons</option>

													
													<option value="3 persons">3 persons</option>

													
													<option value="4 persons">4 persons</option>

													
													<option value="5 persons">5 persons</option>

													
													<option value="6 persons">6 persons</option>

													
													<option value="7 persons">7 persons</option>

													
													<option value="8 persons">8 persons</option>

													
													<option value="9 persons">9 persons</option>

													
													<option value="10 persons">10 persons</option>

													
													<option value="10+ persons">10+ persons</option>

													
												</select>

											</div>

											<div class="recipe-search-go">

												<button class="recipe-search-go-btn" name="" value="" type="submit"><i class="fa fa-search"></i></button>

											</div>

										</form>

									</div>

								</div>

							</div>

						</div>

					</div>

				</section>