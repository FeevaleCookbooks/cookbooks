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
				<a href="<?php echo base_url() ;?>login" class="btn">Login</a>
			</span>
			<?php
			}
			?>

			<div class="main_menu">
				
				<ul id="menu-main-menu" class="menu">

				<?php 
					if($this->session->userdata('id') != null) { 
					$idLogado = $this->session->userdata('nome');
					$nomeLogado = $this->session->userdata('nomeLogado');
					?>
					<li id="menu-item-958" class="menu-item">
						<a href="<?php echo site_url("perfil/");?>">
							<i class="fa fa-user"></i>
								 Bem vindo, <?php echo $nomeLogado;?>
						</a>
					</li>
						<?php 
					}
					?>
					<!-- <li id="menu-item-5" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home current-menu-ancestor current-menu-parent menu-item-has-children menu-item-5 has-submenu"><a href="index.html"><i class="fa fa-home"></i></a></li> -->
					<li id="menu-item-958" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-958 has-submenu"><a href="<?php echo site_url("receita/listar"); ?>"><i class="fa fa-cutlery"></i>Receitas</a>
						<!-- <ul class="sub-menu">
							<!<li id="menu-item-964" class="menu-item menu-item-type-taxonomy menu-item-object-recipesets"><a href="recipesets/entrees/index.html"><i class="fa fa-folder-o"></i> Destaques</a></li>
						</ul> -->
					</li>

					<!--<li id="menu-item-358" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#"><i class="fa fa-users"></i> Chefes</a></li>-->
					<?php 
					if($this->session->userdata('id') != null) { ?>
					<li id="menu-item-358"><a href="<?php echo site_url("login/logout");?>">Sair</a></li>
					<?php } ?>
				</ul>				
			</div>

		</div>

	</div>

</header>