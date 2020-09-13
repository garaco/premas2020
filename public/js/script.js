
function eliminarFila(index) {
var cantidad, arrayCantidad=[],arrayIva=[],sumIva=0,ivaTem=0,ivaTotal=0,indice=0,suma=0,totalImporteParcial=0,iva=0,importeTotal=0;
	alertify.confirm('<span class="fa fa-exclamation-triangle fa-2x" style="color: orange;">', "¡ Seguro que desea remover la fila !",
		function(e){
			if (e) {

				$('#tCompra tr').eq(index).each(function () {//obtiene el importe parcial de la fila a eliminar y el iva si es que tiene
					if ($(this).find("td").eq(6).html() != '<div class="alert alert-danger" style="padding: 0px;">Falto ingresar Cantidad y/o Precio Unitario</div>') {
						cantidad = $(this).find("td").eq(6).html();
					}else{
						cantidad=0;
					}
					if ($(this).find("td").eq(8).html() != 0) {
						iva=$(this).find("td").eq(8).html();
					}else{
						iva=0;
					}
				});
				ivaTem=parseFloat(cantidad)*parseFloat(iva);
				$('#tCompra tr').each(function () {//obtene el importe parcial de todas las filas
					arrayCantidad[indice] = $(this).find("td").eq(6).html();
					arrayIva[indice] = $(this).find("td").eq(8).html();
					indice++;
				});
				$('#fila'+index).remove();
				for (var i = 1; i < arrayCantidad.length; i++) {

					if (arrayCantidad[i] != '<div class="alert alert-danger" style="padding: 0px;">Falto ingresar Cantidad y/o Precio Unitario</div>') {

						suma=parseFloat(suma)+parseFloat(arrayCantidad[i]);
					}else{
						suma=parseFloat(suma)+0;
					}
					if (arrayIva[i] != 0) {
							sumIva=parseFloat(sumIva)+(parseFloat(arrayIva[i])*parseFloat(arrayCantidad[i]));
					}else
					{
						sumIva=parseFloat(sumIva)+0;
					}
				}
				totalImporteParcial=(suma >= parseFloat(cantidad)) ? suma-(parseFloat(cantidad)) : (parseFloat(cantidad))-suma;
				ivaTotal=sumIva-parseFloat(ivaTem);
				console.log('suma '+suma+' cantidad '+ cantidad+' iva '+sumIva+' iva fila'+iva);
				// iva = totalImporteParcial*0.16;
				 importeTotal = totalImporteParcial+ivaTotal;
				// console.log(totalImporteParcial+' '+iva+' '+importeTotal+' '+arrayCantidad.length);
				if ($("#tCompra tr").length == 1) {
						$("#iva").val('0');
						$("#ImporteTotal").val('0');


				}else{

						$("#iva").val(ivaTotal.toFixed(2));
						$("#ImporteTotal").val(importeTotal.toFixed(2));
						sumIva=0;ivaTem=0;ivaTotal=0;suma=0;totalImporteParcial=0;iva=0;importeTotal=0;cantidad=0;
				}


			alertify.success('Fila removida');

			}

		},function () {	});
	return false;
}
function eliminarFilaReq(index) {
	alertify.confirm('<span class="fa fa-exclamation-triangle" style="color: orange;"><span style="color: white;">Alerta</span>', "¡ Seguro que desea remover la fila !",
		function(e){
			if (e) {

				$('#fila'+index).remove();

			alertify.success('Fila removida');
			if ($("#tablaFormRequisicion tr").length == 0) {
				$('#action').hide();
				$('#Enviar').hide();
			}

			}

		},function () {	});
	return false;
}
// para ocultar el alert
$('#success-alert').fadeTo(5000, 500).slideUp(500, function () {
	$('#success-alert').alert('close');
});

//Para asignar datatables a los paa y requisicones, cuando los usuarios de cada departamento entren
$(document).ready( function () {
	var num_tabla=parseInt($("#num_tabla").val());
	var total=(num_tabla > 0)?num_tabla:1;
	for (var i =1 ; i <= total; i++) {

			}
});

function mayus(e) {
	e.value = e.value.toUpperCase();
}
