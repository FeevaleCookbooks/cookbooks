</nav>
<div class="logar">
  <div class="telaLogin">
    <form role="form" action="<?php echo site_url('login/checkLogin');?>" method="post">
      <div class="form-group">
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="exampleInputPassword1" name="pass" placeholder="Senha">
      </div>
      <button type="submit" class="btn btn-default" style="float: right;">Entrar</button>
    </form>
  </div>
</div>