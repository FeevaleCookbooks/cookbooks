<?php

$this->load->view('includes/header.php');
$this->load->view('includes/top.php');
?>
<section id="blog-post">

    <div id="recipe-block" class="container">

        <div class="one_half first cbp-so-section" style="margin-bottom: 0;">

            <div class="recipe-block">

                <div class="register-page-title">

                    <i class="fa fa-user"></i>Cadastre-se
                </div>

                <form class="form-item" action="<?php echo base_url().'usuario/inserir_usuario' ?>" id="primaryPostForm" method="POST" enctype="multipart/form-data">

                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa fa-user"></i>Nome:</label>
                        <input type="text" name="nome" class="text" value="" maxlength="30" class="form-text required" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa fa-key"></i>Senha:</label>
                        <input type="password" name="senha" class="text" maxlength="15" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>E-mail:</label>
                        <input type="text" name="email" class="text" value="" maxlength="30" class="form-text required" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Cidade:</label>
                        <input type="text" name="cidade" class="text" value="" maxlength="30" class="form-text required" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Profissao:</label>
                        <input type="text" name="profissao" class="text" value="" maxlength="30" class="form-text" />
                    </fieldset>
                    
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Observacao:</label>
                        <input type="text" name="observacao" class="text" value="" maxlength="100" class="form-text" />
                    </fieldset>
                    <fieldset class="input-full-width">
                        <label for="edit-title" class="control-label"><i class="fa"></i>Foto:</label>
                        <input type="text" name="foto" class="text" value="" maxlength="100" class="form-text" />
                    </fieldset>

                    <div class="publish-ad-button">
                        <input type="hidden" name="submit" value="Cadastrar" id="submit" />
                        <button class="btn form-submit" id="edit-submit" name="op" value="Publish Ad" type="submit"><i class="fa fa-check"></i>Cadastrar</button>
                    </div>

                </form>

            </div>

        </div>


    </div>      

</section>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->view('includes/footer.php');
?>
