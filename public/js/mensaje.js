alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
function mensajeSave() {
	alertify.success("¡ Datos Guardados !");
}
function mensajeEdit() {
	alertify.confirm("¿ Desea continuar ?", function(e) {
		if (e) {
			alertify.success('Modificando...');
		}
		else{
			$('#ventana').modal('hide');
		}
	});

}
function closeModal() {
	$('#ventana').modal('hide');
}
// validacion para campos de exportar por estado y fecha
function validarExportEF() {
	var correcto=true;

		if(document.getElementById('selectEstado').value == '0'){
			correcto=false;
		}
		if(document.getElementById('FechaDesde').value == ''){
			correcto=false;
		}
		if(document.getElementById('FechaHasta').value == ''){
			correcto=false;
		}
		if(!correcto){
			alertify.alert('<span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo no está correcto ¡");

		}
	return correcto;

}
// validacion para campos de exportar por estado
function validarExportF() {
	var correcto=true;
		if(document.getElementById('fechaDesde').value == ''){
			correcto=false;
		}
		if(document.getElementById('fechaHasta').value == ''){
			correcto=false;
		}
		if(!correcto){
			alertify.alert('<span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo no está correcto ¡");

		}
	return correcto;
}
function validarReq() {
	var correcto=true;
	if(document.getElementById('idHidden').value > 1){
		if(document.getElementById('jefe').value == ''){
			correcto=true;
		}
		if(document.getElementById('depa').value == ''){
			correcto=true;
		}
		if(document.getElementById('archivo').value == ''){
			correcto=true;
		}
	}else{
		if(document.getElementById('Num').value == ''){
			correcto=false;
		}
		if(document.getElementById('recepcion').value == ''){
			correcto=false;
		}
		if(document.getElementById('reporte').value == ''){
			correcto=false;
		}
		if(document.getElementById('jefe').value == '0'){
			correcto=false;
		}
		if(document.getElementById('depa').value == '0'){
			correcto=false;
		}
		if(document.getElementById('concepto').value == ''){
			correcto=false;
		}
		if(document.getElementById('monto').value == ''){
			correcto=false;
		}
		// if(document.getElementById('archivo').value == ''){
		// 	correcto=false;
		// }
		if(!correcto){
			alertify.alert('<span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo no está correcto ¡");

		}else{
			alertify.success("¡ Datos Guardados !");
		}

	}
	return correcto;
}

function validarsql(btn1,btn2) {
	var correcto=true;
	var canDismiss = false;
	document.getElementById(btn1).disabled = true;
	document.getElementById(btn2).disabled = true;
	alertify.set('notifier','position', 'top-center');
	var notification = alertify.success('<div class="spinner-border text-light" role="status"> <span class="sr-only"></span> </div> <label class="font-weight-bold text-white">Cargando....</label>');
	notification.ondismiss = function(){ return canDismiss; };
	setTimeout(function(){ canDismiss = true;}, 5000000);
	return correcto;
}
function validarSolPa() {
	var correcto=true;
		if(document.getElementById('proveedor').value == ''){
			correcto=false;
		}
		if(document.getElementById('SPconcepto').value == ''){
			correcto=false;
		}
		if(document.getElementById('SPmonto').value == ''){
			correcto=false;
		}
		if(document.getElementById('Revisado').value == '0'){
			correcto=false;
		}
		if(document.getElementById('fsolicitud').value == ''){
			correcto=false;
		}
		if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo no está correcto ¡");

		}else{
			alertify.success("¡ Datos Guardados !");
		}
	return correcto;
}
function validarSMC() {
	var correcto=true;
		if(document.getElementById('SMC').value == ''){
			correcto=false;
		}
		if(document.getElementById('SMCfechaRecepcion').value == ''){
			correcto=false;
		}
		if(document.getElementById('SMCfechaReporte').value == ''){
			correcto=false;
		}
		if(document.getElementById('SMCjefe').value == '0'){
			correcto=false;
		}
		if(document.getElementById('SMCdepartamento').value == '0'){
			correcto=false;
		}
		if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo no está correcto ¡");

		}else{
			alertify.success("¡ Datos Guardados !");
		}
	return correcto;
}
function mensajeError() {
	alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! no hay datos ¡");
}

function validarUserPass() {
	var correcto=true;
	if (document.getElementById('userActual').value == '') {
		 correcto=false;
	}
	if (document.getElementById('username').value == '') {
		 correcto=false;
	}
	if (document.getElementById('password').value == '') {
		 correcto=false;
	}
	if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo está vacío  ¡");

		}
	return correcto;
}
//============================= valida fechas de la orden de compra ======================//
function CompararFecha() {
	var form = document.formulario;
	var fecha1 = new Date(form.fecha.value);
	var fecha2 = new Date(form.fechaEntrega.value);
	// if (fecha1.getTime() == fecha2.getTime()) {
	// 	alertify.alert(" &#x1F6AB ! Las fechas no deben ser iguales  ¡");
	// 	$('#fecha').val(" ");
	// 	$('#fechaEntrega').val(" ");
	// }
	// else 
	if(fecha1.getTime() > fecha2.getTime()){
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! La fecha de entrega es menor que la otra fecha, por favor ingrese otra fecha de entrega ¡");
		$('#fechaEntrega').val(" ");
	}
}

function ValidarOrdenCompra() {
	var correcto=true;
	var num=$('#select_num_requisicion').val();
	if (document.getElementById('proveedor').value == '0') {
		 correcto=false;
	}
	if (document.getElementById('NumCompra').value == '') {
		 correcto=false;
	}
	if (document.getElementById('fecha').value == '') {
		 correcto=false;
	}
	if (document.getElementById('fechaEntrega').value == '') {
		 correcto=false;
	}
	if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");

	}
	return correcto;
}
//============ valida los datos general de orde de requisicion ======================
function validarRBS_Entrada() {
	var correcto=true;
	if (document.getElementById('FechaEntrega').value == '') {
		 correcto=false;
	}
	if (document.getElementById('SelectJefeAreaRBS')) {
		if (document.getElementById('SelectJefeAreaRBS').value == '0') {
		 correcto=false;
	}	
	}
	if (document.getElementById('departamento')) {
		if (document.getElementById('departamento').value == '0') {
		 correcto=false;
	}	
	}


	if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>'," &#x1F6AB ! Algún campo está vacío  ¡");

		}
	return correcto;
}
//====================== valida la fecha de registro de requisicion =========================//
function CompararFechaRBS() {
	// var form = document.formulario;
	var fecha1 = new Date($('#fSolicitud').val());
	var fecha2 = new Date($('#FechaEntrega').val());
	if (fecha1.getTime() == fecha2.getTime()) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;"> Alerta</span>'," &#x1F6AB ! Las fechas no deben ser iguales  ¡");
		$('#FechaEntrega').val(" ");
	}
	else if(fecha1.getTime() > fecha2.getTime()){
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;"> Alerta</span>'," &#x1F6AB ! La fecha de entrega es menor que la fecha de solicitud, por favor ingrese otra fecha de entrega ¡");
		$('#FechaEntrega').val(" ");
	}
}
//====================== valida la solicitud en general de la requisicion =========================//
function validarRBS_Salida(nombreBoton,mensaje) {
	var correcto=true;
	var num_fila=$('#indice').val();
	// alert(num_fila);
	for (var i = 0; i <= num_fila; i++) {
			if ($('#proyecto'+i).val() == '0') {
				 correcto=false;
				 $('#proyecto'+i).css('border-color','red');
			}else if($('#proyecto'+i).val() != '0'){
				 $('#proyecto'+i).css('border-color','green');
				 correcto=true;
			}
			if ($('#meta'+i).val() == '0') {
				 correcto=false;
				 $('#meta'+i).css('border-color','red');
			}else if($('#meta'+i).val() != '0'){
				 $('#meta'+i).css('border-color','green');
				 correcto=true;
			}
			if ($('#partida'+i).val() == '0') {
				 correcto=false;
				 $('#partida'+i).css('border-color','red');
			}else if($('#partida'+i).val() != '0'){
				 $('#partida'+i).css('border-color','green');
				 correcto=true;
			}
			if ($('#descripcion'+i).val() == '0' || $('#descripcion'+i).val() == null) {
				 correcto=false;
				 $('#descripcion'+i).css('border-color','red');
			}else if($('#descripcion'+i).val() != '0'){
				 $('#descripcion'+i).css('border-color','green');
				 correcto=true;
			}		

		}
		if ($('#concepto').val() == '') {
				 correcto=false;
				 $('#concepto').css('border-color','red');
			}else if($('#concepto').val() != ''){
				 $('#concepto').css('border-color','green');
				 correcto=true;
			}
		if(!correcto){
			alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"> <span style="color: white;">Alerta</span>'," ! Algún campo está vacío  ¡");

		}else{
			alertify.confirm('<span class="fa fa-exclamation-circle" style="color: white;">', 
				'<h5><strong>'+mensaje+'</strong> </h5>', function(e){ 
		
				if (e) {
					Confirmar=true;
					// $("#form").submit();
					$('#'+nombreBoton).removeAttr("type");
					$('#'+nombreBoton).attr("type","submit");
					$('#'+nombreBoton).click();
				} else{
				 	Confirmar=false;
				
				} 
	
	},function(){ });	
		}

	return correcto;
}
function validarProveedor() {
	var correcto=true;
	if (document.getElementById('Nombre').value == '') {
		correcto=false;
	}
	if (document.getElementById('RFC').value == '') {
		correcto=false;
	}
	if (document.getElementById('Domicilio').value == '') {
		correcto=false;
	}
	if (document.getElementById('Telefono').value == '') {
		correcto=false;
	}
	if (document.getElementById('Email').value == '') {
		correcto=false;
	}
	if (document.getElementById('Servicio').value == '') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");

	}else{
		var num=$('#Telefono').val();
		if (isNaN(num)==true) {
			 alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Ingresar un valor válido en Telefono. Los valores válidos son del 0-9. ¡");
           correcto=false;
		}
		if (num < 10) {
			 alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! El campo Telefono debe contener 10 digitos ¡");
           correcto=false;
		}
	}
	return correcto;

}
// ============= valida los nuevos registros de los materiales. ========================
function validarMaterial() {
	var correcto=true;
	if (document.getElementById('Concepto').value == '') {
		correcto=false;
	}
	if (document.getElementById('Medida').value == '') {
		correcto=false;
	}
	if (document.getElementById('Precio').value == '') {
		correcto=false;
	}
	if (document.getElementById('Partida').value == '0') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;
}
// =============== valida entrada y saluda de existencia de materiales =============
function validaExistencia() {
	var correcto=true;
	if (document.getElementById('Existencia').value == '') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Campo vacío  ¡");
	}
	return correcto;
}
// ============= valida partida, proyecto y meta ======================================
function validar() {
	var correcto=true;
	if (document.getElementById('codigo').value == '') {
		correcto=false;
	}
	if (document.getElementById('concepto').value == '') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;
}
function validarJefeArea() {
	var correcto=true;
	if (document.getElementById('sufijo').value == '0') {
		correcto=false;
	}
	if (document.getElementById('nombre').value == '') {
		correcto=false;
	}
	if (document.getElementById('paterno').value == '') {
		correcto=false;
	}
	if (document.getElementById('materno').value == '') {
		correcto=false;
	}
	if (document.getElementById('departamento').value == '0') {
		correcto=false;
	}
	if (document.getElementById('area').value == '0') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;

}
function validarDepartamento() {
	var correcto=true;
	if (document.getElementById('area').value == '0') {
		correcto=false;
	}
	if (document.getElementById('nombreDepto').value == '') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;
}
function validarArea() {
	var correcto=true;
	if (document.getElementById('codigo').value == '') {
		correcto=false;
	}
	if (document.getElementById('NombreArea').value == '') {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;
}

function verificaContra() {
	var correcto=true;
	if (document.getElementById('Nuevopassword').value != document.getElementById('passwordConfirm').value) {
		correcto=false;
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Las contraseñas no coinciden, vuelva a ingresarlas  ¡");
		$('#Nuevopassword').val('');
		$('#passwordConfirm').val('');
	}
	return correcto;
}
function validaUsuario() {
	var correcto=true;
	if (document.getElementById('Usuario').value == '0') {
		correcto=false;
		$("#Usuario").focus();

	}
	// if (document.getElementById('N_usuario').value == '') {
	// 	correcto=false;
	// }
	if (document.getElementById('area').value == '0') {
		correcto=false;
		$("#area").focus();
	}
	if (document.getElementById('departamento').value == '0') {
		correcto=false;
		$("#departamento").focus();
	}
	if (document.getElementById('password').value == '') {
		correcto=false;
		$("#password").focus();
	}
	if (document.getElementById('password_alt').value == '') {
		correcto=false;
		$("#password_alt").focus();
	}
	if (!correcto) {
		alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">'," &#x1F6AB ! Algún campo está vacío  ¡");
	}
	return correcto;
}
$('#Cancelar').on('click', function () {
	alertify.confirm('<span class="fa fa-exclamation-triangle " style="color: orange;">', '<h5>¿ Desea Cancelar la solicitud ?</h5>', function(){ history.back(-1)},function(){ });
});

// Para cancelar las requisiciones
function CancelarRequisicion(num) {
		var id = $("#CancelarRequi"+num).val();		
		alertify.confirm('<span class="fa fa-exclamation-triangle" style="color: orange;">', '<h6>¿ Desea Cancelar la Requisición <strong>'+id+'</strong> ?</h6>', function(e){ 
			
			if (e) {		
				$("#form"+num).submit();
				return true;
			} else{
				return false;
			} 
		
		},function(){ });
}


// Para confirmar envio de requisicion en RBS
function ConfirmarRE(num) {
	alertify.confirm('<span class="fa fa-exclamation-circle" style="color: blue;">', '<h5><strong>Confirmar el envio de la requisición</strong> </h5>', function(e){ 
		
		if (e) {
			Confirmar=true;
			$('#Enviar'+num).removeAttr("type");
			$('#Enviar'+num).attr("type","submit");
			$('#Enviar'+num).click();

		} else{
		 	Confirmar=false;
		
		} 
	
	},function(){ });
}

// $("#btn_GuardarEM").on('click',function() {
// 		alertify.confirm('<span class="fa fa-exclamation-circle fa-2x" style="color: blue;">', '<h5><strong>Confirmar </strong> </h5>', function(e){ 
		
// 		if (e) {
// 			Confirmar=true;
// 			// $('#Enviar'+num).removeAttr("type");
// 			// $('#Enviar'+num).attr("type","submit");
// 			// $('#Enviar'+num).click();

// 		} else{
// 		 	Confirmar=false;
		
// 		} 
	
// 	},function(){ });
// });
function alertaRBS(mensaje) {
	alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;"><span style="color: white;">Alerta</span>',
		"<h4>! "+mensaje+" ¡</h4> ");
}