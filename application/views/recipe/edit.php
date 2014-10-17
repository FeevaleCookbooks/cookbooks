<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
?>

<section id="blog-post">

		<div id="recipe-block" class="container">

			<div class="one_half first cbp-so-section" style="margin-bottom: 0;">

				<div class="recipe-block">

					<div class="register-page-title">

						<i class="fa fa-plus"></i>Editar Receita
					</div>

					<form class="form-item" action="<?php echo base_url();?>receita/editar_receita/<?php echo $row['id_receita'] ;?>" id="primaryPostForm" method="POST" enctype="multipart/form-data">

						
								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-cutlery"></i>Nome da Receita:</label>
									<input type="text" name="nome_receita" class="text" value="<?php echo $row['nome'] ;?>" maxlength="30" class="form-text required" />

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-folder-o"></i>Categoria:</label>
									<select name="categoria">
										<option value=""></option>
										<?php
										for($i = 1; $i < 10; $i++){
										?>
										<option <?php echo $row['categoria'] == $i ? "selected=selected" : '';?> value="<?php echo $i ;?>">Categoria <?php echo $i; ?></option>
										<?php
										}
										?>
									</select>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-key"></i>Ingredientes:</label>
									<textarea name="ingredientes" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"><?php echo $row['ingredientes'] ;?></textarea>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Modo de Preparo:</label>
									<textarea name="modo_preparo" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"><?php echo $row['modo_preparo'] ;?></textarea>

								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-info-circle"></i>Observações:</label>
									<textarea name="observacao" class="text" style="width: 80%; width: -webkit-calc(100% - 100px); width: calc(100% - 100px);height:140px;"><?php echo $row['observacao'] ;?></textarea>

								</fieldset>


								<fieldset class="input-half-width">

									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Ativo:</label>

									<input <?php echo $row['ativo'] == '1' ? "checked=checked" : "" ;?> 
									type="radio" 
									name="ativo" 
									value="1" 
									style="float:left; width:30px;margin-top:15px;" />
								</fieldset>

								<fieldset class="input-half-width">
									<label for="edit-title" class="control-label"><i class="fa fa-file-text-o"></i>Inativo:</label>
									<input <?php echo $row['ativo'] == '0' ? "checked=checked" : "" ;?> 
									type="radio" name="ativo" value="0" style="float:left;width:30px;margin-top:15px;" />
								</fieldset>


								<fieldset class="input-full-width">

									<label for="edit-title" class="control-label"><i class="fa fa-picture-o"></i>Foto:</label>
									<input type="file" name="foto" />

								</fieldset>


								<div class="publish-ad-button">
									<input type="hidden" name="submit" value="Register" id="submit" />
									<button class="btn form-submit" id="edit-submit" name="op" value="Publish Ad" type="submit"><i class="fa fa-check"></i>Salvar</button>
								</div>

					</form>

				</div>

			</div>


			<div class="one_half cbp-so-section" style="margin-bottom: 0;">

				<div class="recipe-block">

					<div class="register-page-title">
						<i class="fa fa-list"></i>Lista de Receitas
					</div>


					<table class="table shop_table">
						<?php
						foreach ($row_recipe as $recipe) {
						?>
						<tr>
							<td><?php echo $recipe->nome ;?></td>
							<td width="7%">
								<a href="<?php echo base_url();?>receita/edit/<?php echo $recipe->id_receita;?>" class="pull-right" role="button">
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td width="7%">
								<a href="<?php echo base_url();?>receita/delete/<?php echo $recipe->id_receita;?>" class="pull-right" role="button">
									<i class="fa fa-times"></i>
								</a>
							</td>
						</tr>
						<?php
						}
						?>
					</table>

				</div>

			</div>

			
		</div>

	</section>



<?php
$this->load->view("includes/footer.php");
?>	