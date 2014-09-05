  <a class="navbar-brand" href="#"></a>
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
      <li><a href="<?php echo site_url('criar_indicador');?>"><i class="fa fa-bar-chart-o"></i> Indicador</a></li>
      <li><a href="<?php echo site_url('categoria_indicador');?>"><i class="fa fa-desktop"></i> Criar grupo de indicador</a></li>
      <li><a href="<?php echo site_url('finalidade');?>"><i class="fa fa-dashboard"></i> Finalidades</a></li>
      <li><a href="<?php echo site_url('setor');?>"><i class="fa fa-table"></i> Unidade</a></li>
      <li><a href="<?php echo site_url('usuario');?>"><i class="fa fa-font"></i> Criar usuário</a></li>
      <li><a href="<?php echo site_url('relatorio');?>"><i class="fa fa-bar-chart-o"></i> Relatório</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right navbar-user">
      <li class="dropdown alerts-dropdown">
      </li>
      <li class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle" id="downPerfil" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nomeLogado')?> <b class="caret"></b></a>
        <ul class="dropdown-menu" style="display:none;" id="perfil">
          <li><a href="<?php echo site_url('login/logout');?>"><i class="fa fa-power-off"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>