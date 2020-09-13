
var i=$("#indice").val();
$(document).on('ready', funcionPrincipal());

function funcionPrincipal() {
	$('#btnNuevaFila').on('click', funcionNuevaFila);
}
function funcionNuevaFila() {
	$('#tablaFormRequisicion')
	.append
	(
		$('<tr id="fila'+i+'">')
		.append
		(
			$('<td>')
			.append
			( $('<div>').addClass('row')
				.append
				(
					$('<div>').addClass('col-sm-6')
					.append
					(
						$('<select id="meta'+i+'" name="meta[]" data-cont="'+i+'" data-model="meta'+i+'">').attr('type', '').addClass('form-control badge')
						.append
						(
						metas(i)
						)
						
						
					),
					$('<div>').addClass('col-sm-6')
					.append
					(
						$('<select id="proyecto'+i+'" name="proyecto[]" data-cont="'+i+'" data-model="proyecto'+i+'">').attr('type', '').addClass('form-control badge')
					)
				)
				
			)
		)
		.append
		(
			$('<td>')
			.append
			(
				$('<select name="partida[]" id="partida'+i+'" data-cont="'+i+'" data-model="partida'+i+'">').addClass('form-control badge')
				
			)
		)
		.append
		(
			$('<td>')
			.append
			(
				$('<input name="cantidad[]" id="cantidad'+i+'" data-cont="'+i+'" data-model="RBS" min="1">').attr('type', 'number').addClass('form-control cantidad form-control-sm')
			)
		)
		.append
		(
			$('<td>')
			.append
			(
				$('<select name="descripcion[]" id="descripcion'+i+'" data-cont="'+i+'" data-model="descripcion'+i+'">').attr('type', '').addClass('form-control form-control-sm')
			)
		)
		.append
		(
			$('<td colspan="2">')
			.append
			( $('<div id="MedidaCosto'+i+'">').addClass('row')
				.append
				(
					$('<div>').addClass('col-sm-6'),
					$('<div>').addClass('col-sm-6')
				)
				
			)
		)
		.append
		(
			$('<button id="borrar'+i+'" onclick="return eliminarFilaReq('+i+');" data-toggle="tooltip" data-placement="top" title="Remover fila"><span class="fa fa-minus-circle">').addClass('btn btn-sm btn-danger badge')
		)
		
	);
		if ($("#tablaFormRequisicion tr").length != 0) {
			$('#action').show();
			$('#Enviar').show();			
			var diff=$('#diff').val();
			var diff2=parseInt(diff);
			if (diff2 < 4) {
				$('#action').attr('disabled',true);
			}
	}
	$('#indice').val(i);	
	i++;

}
// function proyectos(i) {
// 	var model='MaterialReq',index=i;
// 	var idUser=$('#idUser').val();
// 	  $.ajax({
//       url: url_request+model+'/getProyecto',
//       type: 'POST',
//       dataType: 'json',
//       data: {
//           model: model,
//           method: 'getProyecto',
//           idUser : idUser
//       },
//       success: function (response) {
//       //	$('#proyecto'+index).append('<option value="'+response[0]+'" ></option>');
//           for (var i = 0; i < response.length; i++) {

//           	$('#proyecto'+index).append('<option value="'+response[i]+'">'+response[i]+'</option>');
//           }
//       }
//   });
// }

function metas(i) {
	console.log("response");
	var model='MaterialReq',index=i,metas={'id':"",'Concepto':""};
	var idUser=$('#idUser').val();
	  $.ajax({
      url: url_request+model+'/getMetas',
      type: 'POST',
      dataType: 'json',
      data: {
          model: model,
          method: 'getMetas',
          idUser : idUser,
          metas: ''
      },
      success: function (response) {
      	// var datax = JSON.parse(response); //lo cnvierte en json
      	$('#meta'+index).append('<option value="0" ></option>');
          // for (var i = 0; i < response.length; i++) {

          // 	$('#meta'+index).append('<option value="'+response[i]+'">'+response[i]+'</option>');
          // }
          	$.each(response.IdMeta,function (key,value) {
          		$('#meta'+index).append('<option value="'+response.IdMeta[key]+'">'+response.Enum[key]+'</option>');
          		
          	});

      }
  });
}

