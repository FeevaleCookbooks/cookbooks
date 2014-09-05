$(document).ready(function(){

	$('#alerta').click(function(){
		$('#perfil').hide();
	});

	$('#downPerfil').click(function(){
		$('#alertas').hide();
		$('#perfil').toggle('200');
	});


    $( "#dataUm" ).datepicker();
    $( "#dataDois" ).datepicker();


    $('#pai').click(function(){
		$('#cat_pai').hide();
	});

	$('#pai').click(function(){
		$('#cat_pai').hide();
	});

	$('#filho').click(function(){
		$('#cat_pai').show();
	});


    $("#alertaOdin").click(function(){

      var path =  window.location.protocol +"//" + window.location.hostname + "/info/notificacao/updateNotificacaoOdin/";
      
      $.ajax({
          url: path,
          beforeSend: function(){
              $("#alertaOdin").html('<a href="#" class="dropdown-toggle" id="alertaOdin" data-toggle="dropdown"><i class="fa fa-bell"></i> Alertas Nórdicos <span class="badge">0</span> <b class="caret"></b></a>');
          },  
          success:function(htm){
              $("#alertaOdin").html('<a href="#" class="dropdown-toggle" id="alertaOdin" data-toggle="dropdown"><i class="fa fa-bell"></i> Alertas Nórdicos <span class="badge">0</span> <b class="caret"></b></a>');
              $('#alertas').toggle('200');

          }
      });
    });

    $("#alertaUser").click(function(){

      var path =  window.location.protocol +"//" + window.location.hostname + "/info/notificacao/updateNotificacaoUser/";
      
      $.ajax({
          url: path,
          beforeSend: function(){
              $("#alertaUser").html('<a href="#" class="dropdown-toggle" id="alertaUser" data-toggle="dropdown"><i class="fa fa-bell"></i> Notificação <span class="badge">0</span> <b class="caret"></b></a>');
          },  
          success:function(htm){
              $("#alertaUser").html('<a href="#" class="dropdown-toggle" id="alertaUser" data-toggle="dropdown"><i class="fa fa-bell"></i> Notificação <span class="badge">0</span> <b class="caret"></b></a>');
              $('#alertas').toggle('200');

          }
      });
    });
	
})

function validaFinalidade(){

	if($('#nomeFinalidade').val() != ''){
		
		return true;

	}else{

		alert('Preencha todos os campos');
		return false;

	}

}

function validaMeta(){

  if($('#descricaoMeta').val() != '' || $('#valorMeta').val() != ''){
    
    return true;

  }else{

    alert('Preencha todos os campos');
    return false;

  }

}

function validaChamado(){

  
  if($('#motivo').val() == 'Motivo do Problema' || $('#subcategoria').val() == '+ Detalhes'  || $('#mensagem').val() == ''){

    alert('Preencha todos os campos para abertura do chamado');
    return false;

  }else{

    return true;

  }

}

$(document).ready(function(){
    $("#motivo").change(function(){
        var id_motivo = $("#motivo option:selected").attr('id');
            
        $.ajax({
            type:'POST',
            data:{
                "motivo":id_motivo
            },
            url:"getSubCategoriaAjax/",
            beforeSend: function(){
                $("#subcategoria").html('aguarde...');
            },  
            success:function(htm){
                $("#subcategoria").html(htm);
            }
        });
    })
});



