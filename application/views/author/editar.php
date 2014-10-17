<?php
$this->load->view("includes/header.php");
$this->load->view("includes/top.php");
$this->load->view("includes/footer.php");

//var_dump($dados_perfil);
?>
<section id="page-title">

		<div class="container">

			<h1 class="page-title">
				Editando perfil: <?=$dados_perfil[0]['nome']; ?></h1>
		</div>

	</section>
	<br/>
<section>
	    <div id="recipe-block" class="container">

        <div class="one_half first cbp-so-section" style="margin-bottom: 0;">

            <div class="recipe-block">

                <form class="form-item" action="<?php echo base_url().'perfil/salvar_edicao' ?>" id="primaryPostForm" method="POST" enctype="multipart/form-data">

                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa fa-user"></i>Nome:</label>
                        <input type="text" name="nome" class="text" value="<?php echo $dados_perfil[0]['nome'];?>" maxlength="30" class="form-text required" />
                    </fieldset>
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>E-mail:</label>
                        <input type="text" name="email" class="text" value="<?php echo $dados_perfil[0]['email'];?>" maxlength="30" class="form-text" style="background: #EEE; cursor: not-allowed; color:#777" readonly />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Cidade:</label>
                        <input type="text" name="cidade" class="text" value="<?php echo $dados_perfil[0]['cidade']; ?>" maxlength="30" class="form-text required" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Profissao:</label>
                        <input type="text" name="profissao" class="text" value="<?php echo $dados_perfil[0]['profissao']?>" maxlength="30" class="form-text" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Observacao:</label>
                        <input type="text" name="observacao" class="text" value="<?php echo $dados_perfil[0]['observacao'];?>" maxlength="100" class="form-text" />
                    </fieldset>
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Foto:</label>
                        <input type="text" name="foto" class="text" value="<?php echo $dados_perfil[0]['foto']?>" maxlength="100" class="form-text" />
                    </fieldset>

                    <div class="publish-ad-button">
                        <input type="hidden" name="submit" value="Cadastrar" id="submit" />
                        <button class="btn form-submit" id="edit-submit" name="op" value="Publish Ad" type="submit"><i class="fa fa-check"></i>Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
</section>