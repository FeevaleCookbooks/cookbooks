<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
?>

<section id="blog-post">

		<div id="recipe-block" class="container">

			<div class="one_half first cbp-so-section" style="margin-bottom: 0;">

				<div class="recipe-block">

					<div class="register-page-title">

						<i class="fa fa-user"></i>Login Form
					</div>

					<form class="form-item" action="<?php echo site_url('login/checkLogin');?>" id="primaryPostForm" method="POST" enctype="multipart/form-data">

						
						
								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-user"></i>E-mail:</label>
									<input type="text" id="exampleInputEmail1" name="email" class="text" value="" maxlength="30" class="form-text required" />

								</fieldset>

								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-key"></i>Password:</label>
									<input type="password" id="exampleInputPassword1" name="pass" class="text" maxlength="15" />

								</fieldset>

								<fieldset class="input-full-width">

									<input name="rememberme" type="checkbox" value="forever" style="float: left; width: auto; margin-right: 5px; margin-top: 2px;"/><span style="margin-left: 10px; float: left; margin-bottom: 81px;">Remember me</span>

								</fieldset>

								<div class="publish-ad-button">
									<input type="hidden" name="submit" value="Register" id="submit" />
									<button class="btn form-submit" id="edit-submit" name="op" value="Publish Ad" type="submit"><i class="fa fa-check"></i>Login</button>
								</div>

					</form>

				</div>

			</div>

			
		</div>

	</section>



<?php
$this->load->view("includes/footer.php");
?>	