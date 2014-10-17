<header id="header">

	<div class="container">

		<div class="full" style="margin-bottom: 0;">

			<?php 
			if($this->session->userdata('id') != null) { 
			?>
			<span class="new-recipe">
				<a href="<?php echo base_url() ;?>receita/add" class="btn">Adicionar Receita</a>
			</span>
			<?php
			} else {
			?>
			<span class="new-recipe">
				<a href="<?php echo base_url() ;?>/login" class="btn">Login</a>
			</span>
			<?php
			}
			?>

			<div class="main_menu">
				<?php 
					if($this->session->userdata('id') != null) { 
					$idLogado = $this->session->userdata('nome');
					?>

					<a href="<?php echo site_url("perfil/");?>"> Bem vindo, <?php echo $idLogado;?></a>
					<?php }
				?>
				<ul id="menu-main-menu" class="menu">
					<li id="menu-item-5" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home current-menu-ancestor current-menu-parent menu-item-has-children menu-item-5 has-submenu"><a href="index.html"><i class="fa fa-home"></i></a></li>
					<li id="menu-item-958" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-958 has-submenu"><a href="recipes/index.html"><i class="fa fa-cutlery"></i> Recipes</a>
						<ul class="sub-menu">
							<li id="menu-item-964" class="menu-item menu-item-type-taxonomy menu-item-object-recipesets"><a href="recipesets/entrees/index.html"><i class="fa fa-folder-o"></i> Entrees</a></li>
						</ul>
					</li>
					<li id="menu-item-358" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#"><i class="fa fa-users"></i> Chefs</a></li>
					<?php 
					if($this->session->userdata('id') != null) { ?>
					<li id="menu-item-358"><a href="<?php echo site_url("login/logout");?>">Logout</a></li>
					<?php } ?>
				</ul>				
			</div>

		</div>

	</div>

</header>