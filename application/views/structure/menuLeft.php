  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
      <li><a href="<?php echo site_url('indicador');?>"><i class="fa fa-dashboard"></i> Meus Indicadores</a></li>  
      <!--<li><a href="<?php echo site_url('indicador/indicador_pendente');?>"><i class="fa fa-edit"></i> Analide de Indicadores</a></li>-->
    </ul>

    <ul class="nav navbar-nav navbar-right navbar-user">
      <li class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle" id="downPerfil" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nomeLogado')?> <b class="caret"></b></a>
        <ul class="dropdown-menu" style="display:none;" id="perfil">
          <li><a href="<?php echo site_url('login/logout');?>"><i class="fa fa-power-off"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>