<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
?>

<section id="blog-post">

		<div id="recipe-block" class="container">

			<div class="one_half first cbp-so-section" style="margin-bottom: 0;">

				<div class="recipe-block">

					<div class="register-page-title">

						<i class="fa fa-plus"></i>Adiconar Receita
					</div>

					<form class="form-item" action="<?php echo base_url();?>receita/inserir_receita" id="primaryPostForm" method="POST" enctype="multipart/form-data">

						
								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-cutlery"></i>Nome da Receita:</label>
									<input type="text" name="nome_receita" class="text" value="" maxlength="30" class="form-text required" />

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-folder-o"></i>Categoria:</label>
									<select name="categoria">
										<option value=""></option>
										<option value="1">Categoria 1</option>
										<option value="2">Categoria 2</option>
										<option value="3">Categoria 3</option>
										<option value="4">Categoria 4</option>
										<option value="5">Categoria 5</option>
									</select>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-key"></i>Ingredientes:</label>
									<textarea name="ingredientes" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"></textarea>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Modo de Preparo:</label>
									<textarea name="modo_preparo" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"></textarea>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-info-circle"></i>Observações:</label>
									<textarea name="observacao" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"></textarea>

								</fieldset>


								<fieldset class="input-half-width">

									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Ativo:</label>

									<input type="radio" name="ativo" value="1" style="float:left; width:30px;margin-top:15px;" />
								</fieldset>

								<fieldset class="input-half-width">
									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Inativo:</label>
									<input type="radio" name="ativo" value="0" style="float:left;width:30px;margin-top:15px;" />
								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-picture-o"></i>Foto:</label>
									<input type="file" name="foto" />

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