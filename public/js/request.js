// se optiene la direccion
var url_request = window.location.protocol + "//" + window.location.host + "/premas/";
var spinner = '<div id="beforeSend"><img src="'+url_request+'/public/img/loader.svg" alt=""><h4 class="tittle">Cargando...</h4></div>';
// Se optienen los datos de cada variable al abrir la ventana modal
$('#ventana').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var valorBoton = button.data('concepto');
    var operation = button.data('operation');
    var method = button.data('method');
    var name = button.data('name');
    var model = button.data('model');
    var id = button.data('id');
    var tipouser=button.data('tipouser');
    var depto = button.data('depto');
    var modal = $(this);
    var estado = button.data('estado');
    var anio = button.data('anio');
    var mes = button.data('mes');
    var datef = button.data('datef');
    var pagDep=$('#pages').val();
    var pagSelect=$('#pag-select').val();
    if(name===undefined){name=model}
// se manda a llamar por ajax
    $.ajax({
      // manda un array con los datos que se requieren
        url: url_request+model+'/'+method,
        type: 'POST',
        data: {
            function: (operation == 'Agregar' || operation == 'Editar') ?  'Insert' : operation,
            method: method,
            model: model,
            id: id,
            tipouser: tipouser,
            valorBoton: valorBoton,
            depto: depto,
            anio:anio,
            mes: mes,
            datef: datef,
            pagDep:pagDep,
            pagSelect:pagSelect
        },

        beforeSend: function () {
          //le asigna el titulo al emcabezado
            modal.find('.modal-title').html('<h3 style="margin: 0">' + operation +'  '+name+ '</h3>');
            modal.find('.modal-body').html(spinner);
        },
        //le asigna el cuerpo a la ventana modal

        success: function (data) {
            modal.find('.modal-body').html(data);
              modal.find('.modal-body #Num').focus();
            if(operation=='Editar'){
              if (estado == 'AUTORIZADO') {
                //$('#Status').attr('disabled',false);
                $('#selectEB').attr('disabled',true);
              }else{
                //$('#Status').attr('disabled',true);
                $('#selectEB').attr('disabled',false);
              }
               modal.find('.modal-body  #recepcion, #jefe, #depa, #archivo').prop('readonly',true);
                $('#jefe').attr('disabled',true);
                $('#depa').attr('disabled',true);

            }
              $(".selectAll").on('click',function () {
              $(".selectCkeck").prop('checked', this.checked);
                });
              $(".selectCkeck").on('click',function () {
                if ($('.selectCkeck').length == $('.selectCkeck:checked').length) {
                    $(".selectAll").prop('checked',true);
                }
                else{
                  $(".selectAll").prop('checked',false);
                }
              });
              // esto se ejecuta cuando el admin de R.M. crea una RBS de otro depto
              // y sirve para obtener el id de usuario que esta acargo del depto
              $('#SelectJefeAreaRBS').on('change',function() {
                idDep=$('#SelectJefeAreaRBS').val();
                var model = $(this).data('model');
                $.ajax({
                  url: url_request+model+'/idUser',
                  type: 'POST',
                  data: {
                      model: model,
                      function: 'idUser',
                      method: 'idUser',
                      idDep: idDep
                  },
                  success: function (data) {
                      $('#idUser').val(data);
                  }
              });});
        }
    });
});

function save(model) {

      $.ajax({
          url: url_request+model+'/save',
          type: 'POST',
          data: $('#form').serialize(),
          success: function (data) {
            $('#tableid1').dataTable().fnDestroy();
              $('.container-table').html(data);
              TableReload(1,'#tableid');
           }
      });
  }

// es un metodo para buscar por concepto
$(document).on('keyup','#buscar', function(){
  var date = $(this).val();
  var model = $(this).data('model');
  var user = $(this).data('operation');
    if (!date) {
      $.ajax({
          url: url_request+model+'/search',
          type: 'POST',
          data: {
              model: model,
              function: 'Buscar',
              method: 'search',
              date: date,
              user: user
          },
          success: function (data) {
          $('#table_id1').dataTable().fnDestroy();
          $('.container-table').html(data);
          TableReload(1,'#table_id');
          }
      });
    }else{
            $.ajax({
          url: url_request+model+'/search',
          type: 'POST',
          data: {
              model: model,
              function: 'Buscar',
              method: 'search',
              date: date,
              user: user
          },
          success: function (data) {
            $('#table_id1').dataTable().fnClearTable();
              $('.container-table').html(data);
          }
      });
    }

});

// es un metodo para buscar por requisicion
$(document).on('keyup','#buscarRequi', function(){
  var date = $(this).val();
  var model = $(this).data('model');
    if (!date) {
        $.ajax({
            url: url_request+model+'/search',
            type: 'POST',
            data: {
                model: model,
                function: 'Buscar',
                method: 'search',
                dateRequi: date
            },
            success: function (data) {
              $('#table_id1').dataTable().fnDestroy();
                $('.container-table').html(data);
                TableReload();
            }
        });
    }else{
 $.ajax({
          url: url_request+model+'/search',
          type: 'POST',
          data: {
                model: model,
                function: 'Buscar',
                method: 'search',
                dateRequi: date
          },
          success: function (data) {
            $('#table_id1').dataTable().fnClearTable();
            $('.container-table').html(data);

          }});
    }

});
/////////////////////////////////////
  $('#id').on('change', function(){
    var estado=$('#id').val();
    var model = $(this).data('model');

    $.ajax({
      url: url_request+model+'/llenar',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          estado: estado
      },
      success: function (data) {
          $('.container-table').html(data);
      }

    });

  });


  $('#depa').on('change', function(){
    var area=$('#depa').val();
    var model = $(this).data('model');

    $.ajax({
      url: url_request+model+'/departamento',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          area: area
      },
      success: function (data) {
          $('.container-table').html(data);
      }

    });

  });
  $('#jefe').on('change', function(){
    var depa=$('#jefe').val();
    var model = $(this).data('model');

    $.ajax({
      url: url_request+model+'/departamento',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          depa: depa
      },
      success: function (data) {
          modal.find('.modal-body').html(data);
          modal.find('#depa').html(data);
      }

    });

  });


/////////////////////////////////////// bitacora ///////////////////////////////////////////////////
  $('#filtros').on('change', function(){
    var filtro=$('#filtros').val();
   switch(filtro){
      case "Todos":
         $('#estado').hide();
         $('#Desde').hide();
         $('#Hasta').hide();
         $('#Mes').hide();
         $('#Anio').hide();
         $('#depar').hide();
         $('#ReBuscar').hide();
         $('#autorizado').hide();
         $('#FechaDesde').hide(); //estos para obtener las fechas para solicitud de pago
         $('#FechaHasta').hide(); //estos para obtener las fechas para solicitud de pago
          var opt="0";
          var id="IdBitacora";
          var model = $(this).data('model');
          var user = $(this).data('operation');

            $.ajax({
            url: url_request+model+'/search',
            type: 'POST',
             data: {
                model: model,
                function: 'Buscar',
                method: 'search',
                opt: opt,
                id: id,
                user: user
            },
            success: function (data) {
             $('#table_id1').dataTable().fnDestroy();
              $('.container-table').html(data);
               TableReload();
            }

          });

      break;
      case "Concepto":
         $('#estado').hide();
         $('#Desde').hide();
         $('#Hasta').hide();
         $('#Anio').hide();
         $('#depar').hide();
         $('#ReBuscar').show();
         $('#desde').val(" ");
         $('#hasta').val(" ");
         $('#autorizado').hide();
         $('#FechaDesde').hide(); //esto ocultalas fechas para solicitud de pago
         $('#FechaHasta').hide(); //esto ocultalas fechas para solicitud de pago
         $('#Fechadesde').val(" "); //esto devuelve en 0 las fechas de solicitud de pago
         $('#Fechahasta').val(" "); //esto devuelve en 0 las fechas de solicitud de pago
      break;
      case "Fecha":
         $('#estado').hide();
         $('#Desde').show();
         $('#Hasta').show();
         $('#desde').val(" ");
         $('#hasta').val(" ");
         $('#Anio').show();
         $('#depar').hide();
         $('#ReBuscar').hide();
      break;
      case "Estados":
         $('#estado').show();
         $('#Desde').show();
         $('#Hasta').show();
         $('#desde').val(" ");
         $('#hasta').val(" ");
         $('#Anio').hide();
         $('#depar').hide();
         $('#ReBuscar').hide();
         $('#autorizado').hide();
         $('#FechaDesde').hide(); //esto ocultalas fechas para solicitud de pago
         $('#FechaHasta').hide(); //esto ocultalas fechas para solicitud de pago
         $('#Fechadesde').val(" "); //esto devuelve en 0 las fechas de solicitud de pago
         $('#Fechahasta').val(" "); //esto devuelve en 0 las fechas de solicitud de pago
       break;
       case "Departamento":
         $('#depar').show();
         $('#estado').hide();
         $('#Desde').hide();
         $('#Hasta').hide();
         $('#Anio').hide();
         $('#ReBuscar').hide();
       break;
         case "Autorizado":
         $('#autorizado').show();
         $('#FechaDesde').show();
         $('#FechaHasta').show();
         $('#depar').hide();
         $('#estado').hide();
         $('#Anio').hide();
         $('#ReBuscar').hide();
       break;
    }


  });

    $('#selectE').on('change', function(){
    var estatu=$('#selectE').val();
    var id="Estado";
    var datoHasta = $('#hasta').val();
    var datoDesde = $('#desde').val();
    var model = $(this).data('model');
    var user = $(this).data('operation');

    $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          estatu: estatu,
          id: id,
          datoHasta: datoHasta,
          datoDesde: datoDesde,
          user: user
      },
      success: function (data) {
       $('#table_id1').dataTable().fnDestroy();
        $('.container-table').html(data);
         TableReload();
      }

    });

  });

$('#desde').on('change', function(){
  var datoHasta = $('#hasta').val();
  var datoDesde = $('#desde').val();
  var estatu=$('#selectE').val();
  var id="Estado";
  var model = $(this).data('model');
  $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
      data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          estatu: estatu,
          id: id,
          datoHasta: datoHasta,
          datoDesde: datoDesde
      },
      success: function (data) {
          $('.container-table').html(data);
      }
  });
  return false;
});
$('#hasta').on('change', function(){
  var datoHasta = $('#hasta').val();
  var datoDesde = $('#desde').val();
  var estatu=$('#selectE').val();
  var id="Estado";
  var model = $(this).data('model');

  $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
      data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          estatu: estatu,
          id: id,
          datoHasta: datoHasta,
          datoDesde: datoDesde
      },
      success: function (data) {
       $('#table_id1').dataTable().fnDestroy();
        $('.container-table').html(data);
         TableReload();
      }
  });
  return false;
});
  $('#Depa').on('change', function(){
    var id=$('#Depa').val();

    var model = $(this).data('model');
    $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          id: id
      },
      success: function (data) {
       $('#table_id1').dataTable().fnDestroy();
        $('.container-table').html(data);
         TableReload();
      }

    });

  });
//===========================================================================================================
//                            funcion para buscar requisiciones por año
//===========================================================================================================

 $('.boton_ano').click(function(){
    var boton_ano=$('#boton_ano'+$(this).data('cont')).val();
    var model = $(this).data('model');

     $.ajax({
      url: url_request+model+'/filto_ano',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'filto_ano',
          boton_ano: boton_ano

      },
      success: function (data) {
        $('#table_id1').dataTable().fnDestroy();
        $('.container-table').html(data);
        TableReload(1,'#table_id');
      }

    });
  });


//===========================================================================================================
//                                          Paginacion
//===========================================================================================================

$('.pag').click(function () {

    var valorBoton = $('#boton').val(); //para enviar el tipo de usuario (se utiliza para solicitud de pago)
    var model = $(this).data('model');
    var prev = $('#pag-prev');
    var next = $('#pag-next');
    var p = $(this).data('page');
    var n = ($(".pagination > li").length) - 3;
    var cont = $(this).data('cont');
    var reg = $(this).data('reg');
    var fin=reg;
    var txt= (((p-1)*reg)+1)+'-'+(p*reg)+' de '+cont;
     var lim= ((p-1)*reg);
    if(p == 1){
      txt= '1-'+reg+' de '+cont;
      lim=0;
    } else if(p == n){
      var txt= (((p-1)*reg)+1)+'-'+cont+' de '+cont;
      fin=cont;
    }

    $.ajax({
        url: url_request+model+'/pagination',
        type: 'POST',
        data: {
            model: model,
            function: 'Paginacion',
            method: 'pagination',
            page: lim,
            fin:fin,
            valorBoton
        },
        success: function (data) {
            $('.container-table').html(data);
            $('.info').text(txt);
            if(p == 1)
                prev.parent().addClass('disabled');
            else
                prev.parent().removeClass('disabled');
                prev.parent().addClass('active');

            if(p == n)
                next.parent().addClass('disabled');
            else
                next.parent().removeClass('disabled');
                next.parent().addClass('active');
        }
    });
});

//===========================================================================================================
//                 funcion que permite llenar el select de proyecto,partidas y el campo descripcion, unidad y precio
//                  de las requisiciones
//===========================================================================================================
$("#tablaFormRequisicion").on('change','select',function () {
   var cont = $(this).data('cont');
  var model = $(this).data('model');
  var mes=$('#mes').val();
   id = $(this).val();
   if (model=="partida"+cont) {
 $("#"+"partida"+cont+" option:selected").each(function () {
  id = $(this).val();
  idmeta=$("#meta"+cont).val();
  idProyecto=$("#proyecto"+cont).val();
     $.ajax({
      url: url_request+'RBS'+'/seleccion',
      type: 'POST',
      data: {
        function: 'seleccion',
          method: 'seleccion',
          id: id,
          idmeta: idmeta,
          idProyecto: idProyecto,
          mes:mes
      },
      success: function (data) {
          $('#'+'descripcion'+cont).html(data);
      }
  });
});
   }if(model=="descripcion"+cont){
    var num_cantidad=$('#cantidad'+$(this).data('cont')).val();
    var cont = $(this).data('cont');
    var indice=$("#indice").val();
    var meta = $("#meta"+$(this).data('cont')).val();
    var proyecto = $("#proyecto"+$(this).data('cont')).val();
    var valorI;
    id = $(this).val();
    if (num_cantidad=='') {
      alertify.alert("Alerta"," &#x1F6AB ! Es necesario primero ingresar la cantidad ¡");
      $('#descripcion'+$(this).data('cont')).val("0");
      return;
    }

    $("#"+"descripcion"+cont+" option:selected").each(function () {
      var array=[];
      var mitad=0,primero=0,ultimo=0;
      for (var i = 0; i <= indice; i++) {
        array[i]=i;
      }
      if (cont == 0) {
        primero=array[1];
        var getCoincidencia=0;
        for (var i = primero; i <= indice; i++) {
          var SelectSeleccionado=$("#"+"descripcion0").val();
          var SelectComparar=$("#"+"descripcion"+i).val();
          var entero=parseInt(SelectSeleccionado);
          var entero1=parseInt(SelectComparar);
          if (entero == entero1) {
            getCoincidencia++;
          }
        }
        if (getCoincidencia > 0) {
          alertify.alert("Alerta"," &#x1F6AB ! la opcion que selecciono ya se encuentra seleccionado ¡");
          $('#descripcion0').val(0);
          $('#'+'MedidaCosto0').html('')
          return;
        }
      }
      else if(cont == indice){
        ultimo=[indice-1];
        var getCoincidencia=0;
        for (var i = ultimo; i >= 0; i--) {
          var mensaje="no se encuentra seleccionado";
          var SelectSeleccionado=$("#"+"descripcion"+indice).val();
          var SelectComparar=$("#"+"descripcion"+i).val();
          var entero=parseInt(SelectSeleccionado);
          var entero1=parseInt(SelectComparar);
          if (entero == entero1) {
              getCoincidencia++;
          }
        }
        if (getCoincidencia > 0) {
          alertify.alert("Alerta"," &#x1F6AB ! la opcion que selecciono ya se encuentra seleccionado ¡");
          $('#descripcion'+indice).val(0);
          $('#'+'MedidaCosto'+indice).html('')
          return;
        }
      }
      else{
        mitad=array[cont];
        primero=array[cont-1];
        ultimo=array[cont+1];
        var getCoincidencia=0;
        for (var i = primero; i >= 0; i--) {
          var mensaje="no se encuentra seleccionado";
          var SelectSeleccionado=$("#"+"descripcion"+mitad).val();
          var SelectComparar=$("#"+"descripcion"+i).val();
          var entero=parseInt(SelectSeleccionado);
          var entero1=parseInt(SelectComparar);
          if (entero == entero1) {
            getCoincidencia++;
          }
        }
        for (var i = ultimo; i <= indice; i++) {
          var mensaje="no se encuentra seleccionado";
          var SelectSeleccionado=$("#"+"descripcion"+mitad).val();
          var SelectComparar=$("#"+"descripcion"+i).val();
          var entero=parseInt(SelectSeleccionado);
          var entero1=parseInt(SelectComparar);
          if (entero == entero1) {
            getCoincidencia++;
          }
        }
        if (getCoincidencia > 0) {
          alertify.alert("Alerta"," &#x1F6AB ! la opcion que selecciono ya se encuentra seleccionado ¡");
          $('#descripcion'+mitad).val(0);
          $('#'+'MedidaCosto'+mitad).html('');
          return;
        }

      }
      // [ se envia los datos por ajax ]
        id = $(this).val();
        meta
         $.ajax({
          url: url_request+'RBS'+'/selectUnidadCosto',
          type: 'POST',
          data: {
            function: 'selectUnidadCosto',
              method: 'selectUnidadCosto',
              num_cantidad: num_cantidad,
              id: id,
              mes:mes,
              cont:cont,
              meta: meta,
              proyecto: proyecto
          },
          success: function (data) {
              $('#'+'MedidaCosto'+cont).html(data);
          }
      });
    });
   }if (model=="meta"+cont) {
       $("#"+"meta"+cont+" option:selected").each(function () {
        var idUser=$('#idUser').val();
        idmeta = $(this).val();
      //alert(idmeta+' '+idUser);
         $.ajax({
          url: url_request+'RBS'+'/selectMeta',
          type: 'POST',
          data: {
            function: 'selectMeta',
              method: 'selectMeta',
              idmeta: idmeta,
              idUser : idUser
          },
          success: function (data) {
              $('#'+'proyecto'+cont).html(data);
          }
      });
    });
   }if (model=="proyecto"+cont) {
        var idUser=$('#idUser').val();

      $("#"+"proyecto"+cont+" option:selected").each(function () {
        idProyecto = $(this).val();
        //alert(idProyecto+' '+idUser);
           $.ajax({
            url: url_request+'RBS'+'/selectProyecto',
            type: 'POST',
            data: {
              function: 'selectProyecto',
                method: 'selectProyecto',
                idProyecto: idProyecto,
                idUser : idUser
            },
            success: function (data) {
                $('#'+'partida'+cont).html(data);
            }
        });
      });
   }

});
//===========================================================================================================
//                 funcion que ejecuta modal al seleccionar en select
//                  para orden de compra
//===========================================================================================================
$('#select_num_requisicion').on('change', function () {
  var num_requisicion=$('#select_num_requisicion').val();
  var model=$(this).data('model');
    $.ajax({
      url: url_request+model+'/AgregarRequisicion',
      type: 'POST',
      data: {
        model: model,
        function: 'AgregarRequisicion',
        method: 'AgregarRequisicion',
        num_requisicion: num_requisicion
      },
        beforeSend: function () {
          //le asigna el titulo al emcabezado
            $('.modal-title').html('<h3 style="margin: 0"> Agregar Requisición a Orden de Compra</h3>');
            $('.modal-body').html(spinner);
        },
      success: function (data) {
        $('.modal-body').html(data);
        $('#ventanaCompra').modal('show');
        $('#select_num_requisicion').val(0);
      }
    });
});

//===========================================================================================================
//                click en el boton del modal en orden de compra
//===========================================================================================================
 var indice=0;
  function datos(num) {
    var cantidad={},unidad={},concepto={}, precio_unitario={},numIndice={},idReqYmat={};
    var j=0,cont=0,cont1=0,posicion=[],arrayIva=[];
    var totalMaterial=parseInt(num);
    var folio=$("#folioRe").val();
    var departamento=$("#Departamento").val();
      for (var i = 0; i < totalMaterial; i++) { //para obetener la posicion del checkbox seleccionado
        if ($("#checkbox"+i).is(':checked')) {
            posicion[cont]=$("#checkbox"+i).val(); //si esta activo se almacena su posicion en posicion[]
            cont++;
             j=cont;
        }
      }
      var nfilas=$("#tCompra tr").length;
      if (nfilas == 1) {
        indice=0;
      }
      totalI=parseInt(indice)+parseInt(j);
      lim=indice;
      for (var i = totalI-1; i >= lim; i--) { //para almacenar el indice de cada fila de la tabla
        indice++;
        indicef=indice;
        numIndice[cont1]=indicef;
        cont1++;
      }

    for (var i = 0; i < posicion.length; i++) { // se obtiene la info de la fila de los checkbox activos
      var p=posicion[i];
      idReqYmat[i] = $("#idReqYmat"+p).val();
      cantidad[i] = $('#Cantidad'+p).val();
      unidad[i] = $('#Unidad'+p).val();
      concepto[i] = $('#Concepto'+p).val();
      precio_unitario[i] = $('#Precio_unitario'+p).val();
      arrayIva[i] = ($('#Iva'+p).val() == '')?0:$('#Iva'+p).val();
    }

    ObjetidReqYmat = JSON.stringify(idReqYmat);
    Objetcantidad = JSON.stringify(cantidad);
    Objetunidad = JSON.stringify(unidad);
    Objetconcepto = JSON.stringify(concepto);
    Objetprecio_unitario = JSON.stringify(precio_unitario);
    ObjetIndice = JSON.stringify(numIndice);
    ObjetIva = JSON.stringify(arrayIva);
        $.ajax({
        url: url_request+'Compra'+'/AlmacenarTabla',
        type: 'POST',
        data: {
          model: 'Compra',
          dataType: 'json',
          function:'AlmacenarTabla',
          method: 'AlmacenarTabla',
          ObjetidReqYmat: ObjetidReqYmat,
          Objetcantidad: Objetcantidad,
          Objetunidad: Objetunidad,
          Objetconcepto: Objetconcepto,
          Objetprecio_unitario: Objetprecio_unitario,
          folio: folio,
          departamento:departamento,
          ObjetIndice: ObjetIndice,
          ObjetIva: ObjetIva
        },
        success: function (data) {
         $('#tablaCompra').append(data);
         $('#ventanaCompra').modal('hide');
         var arrayImporteparcial=[],arrayIvaTem=[];
         var input_importe = $('#ImporteTotal').val();
         var Importe_total = (input_importe == '')? 0: parseFloat(input_importe);
         var input_iva = $('#iva').val();
         var iva = (input_iva == '')?0:parseFloat(input_iva);
         var sumaTotal=Importe_total-iva;
         for (var i = 0; i < posicion.length; i++) {
          arrayImporteparcial[i]=(cantidad[i]*precio_unitario[i]);
           sumaTotal=(cantidad[i]*precio_unitario[i])+(sumaTotal);
         }

         //var sumaArrayIva
         for (var i = 0; i < posicion.length; i++) {
          if (arrayIva[i] != 0) {
                iva=(arrayIva[i]*arrayImporteparcial[i])+(iva);
          }

         }
         //iva = (sumaTotal*0.16);
         sumaTotal=sumaTotal+iva;
          $('#iva').val(iva.toFixed(2));
          $('#ImporteTotal').val(sumaTotal.toFixed(2));
        }
      });
  }



//===========================================================================================================
//                llena la tabla para las entradas de los materiales (Orden de compra)
//===========================================================================================================
  $("#SelectNum_compra").on('change',function () {
    var idOrdCom = $("#SelectNum_compra").val();
    var model = $(this).data('model');
    $.ajax({
      url: url_request+model+'/EntradaMaterial',
      type: 'POST',
      data: {
        model: model,
        function:'EntradaMaterial',
        method: 'EntradaMaterial',
        idOrdCom: idOrdCom
      },
      success: function (data) {
       $("#tablaEntradaMat").html(data);
       if (idOrdCom != '0') {
        $("#btn_GuardarEM").show();
        $(".selectAllMat").show();
       }else{
        $("#btn_GuardarEM").hide();
        $(".selectAllMat").hide();
       }

      }

    });
  });
    $(".selectAllMat").on('click',function () {
    $(".selectAddMaterial").prop('checked', this.checked);
      });
    $(".selectAddMaterial").on('click',function () {
      if ($('.selectAddMaterial').length == $('.selectAddMaterial:checked').length) {
          $(".selectAllMat").prop('checked',true);
      }
       else{
        $(".selectAllMat").prop('checked',false);
      }
    });
//===========================================================================================================
//                Envia los datos de los materiales a inventario (Orden de compra)
//===========================================================================================================

$("#btn_GuardarEM").on("click",function(e){
  e.preventDefault();
   var numCheck = $("#num").val();
 var correcto = false;
 for (var i = 0; i < numCheck; i++) {
        if ($("#checkbox"+i).is(':checked')) {
          correcto = true;
        }else{
          correcto=false;
        }
 }
 if (!correcto) {
  alertify.alert('<span class="fa fa-exclamation-triangle " style="color: orange;">',"<h4>! Falta seleccionar material  ¡</h4> ");
 }else{
$('#btn_GuardarEM').attr("disabled", true);
$('#btn_GuardarEM').text("Enviando...");
  $.ajax({
    type: "POST",

    url: url_request+'Compra'+'/AgregarMaterial',
    data: $("#formAddMaterial").serialize(),
    success: function(response){
      var datax = JSON.parse(response); //lo cnvierte en json
      $('#tablaEntradaMat').empty();
      $("#formAddMaterial")[0].reset();
      $("#btn_GuardarEM").hide();
      alertify.success('Datos Guardados');
      $('#SelectNum_compra').empty().append('<option value="0">Seleccione</option>');
      if(datax.status == "success"){
      $.each(datax.IDcompra,function(k,v){
            $("#SelectNum_compra").append('<option value="'+datax.IDcompra[k]+'">'+datax.Num_compra[k]+'</option>');
      });
      $('#btn_GuardarEM').attr("disabled", false);
      $('#btn_GuardarEM').html('<span class="fa fa-check"></span> Guardar');
      }else{
        alertify.error(datax.status);
        $('#btn_GuardarEM').attr("disabled", true);
        $('#btn_GuardarEM').html('<span class="fa fa-check"></span> Guardar');

      }
    },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alertify.error('Ocurrio un error');
        $('#btn_GuardarEM').attr("disabled", true);
        $('#btn_GuardarEM').html('<span class="fa fa-check"></span> Guardar');

  }
  });
 }
});

////////////////////   Solicitudes de pago //////////////////////////////////////7

//===================== busqueda por autorizado a apgar =========================//

  $('#selectAutorizado').on('change', function(){
    var autorizado=$('#selectAutorizado').val();
    var id="Id";
    var model = $(this).data('model');
    var user = $(this).data('operation');

    $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          autorizado: autorizado,
          id: id,
          user: user
      },
      success: function (data) {
          $('.container-table').html(data);
      }

    });

  });
  $('#Fechadesde').on('change', function(){
  var datoHasta = $('#Fechahasta').val();
  var datoDesde = $('#Fechadesde').val();
  var autorizado=$('#selectAutorizado').val();
  var id="";
  var model = $(this).data('model');
  var user = $(this).data('operation');
  $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
      data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          autorizado: autorizado,
          id: id,
          datoHasta: datoHasta,
          datoDesde: datoDesde,
          user: user
      },
      success: function (data) {
          $('.container-table').html(data);
      }
  });
  return false;
});
$('#Fechahasta').on('change', function(){
  var datoHasta = $('#Fechahasta').val();
  var datoDesde = $('#Fechadesde').val();
  var autorizado=$('#selectAutorizado').val();
  var id="";
  var model = $(this).data('model');
  var user = $(this).data('operation');

  $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
      data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          autorizado: autorizado,
          id: id,
          datoHasta: datoHasta,
          datoDesde: datoDesde,
          user: user
      },
      success: function (data) {
          $('.container-table').html(data);
      }
  });
  return false;
});


$("#ExportarPDF").on('change',function () {
  var num = $("#ExportarPDF").val();
  switch(num){
    case '0':
      $("#RangoFecha").hide();
       $("#all").hide();
      // $("#button").hide();

    break;
    case '1':
      // $("#existencia").show();
      $("#all").show();
      $("#RangoFecha").hide();
       // $("#button").show();
    break;
   case '2':
      $("#RangoFecha").show();
      $("#all").hide();
       // $("#existencia").hide();
       // $("#button").show();
    break;
  }
});

$("#paaNew").on('change',function () {
var pag = $('#pages').val();
if(pag==undefined){
  $("#Tdep").val("");
}else{
  $("#Tdep").val(pag);
}
  var num = $("#paaNew").val();
  switch(num){
    case '0':
      $("#Real2").hide();
       $("#Proyeccion2").hide();

    break;
    case '1':
      $("#Proyeccion2").show();
      $("#tipo2").val("proyeccion");
    break;
   case '2':
      $("#Proyeccion2").show();
      $("#tipo2").val("Real");
    break;
  }
});

$("#paaOld").on('change',function () {
var pag = $('#pages').val();
if(pag==undefined){
  $("#TdepN").val("");
}else{
  $("#TdepN").val(pag);
}
  var num = $("#paaOld").val();
  switch(num){
    case '0':
      $("#Real").hide();
       $("#Proyeccion").hide();

    break;
    case '1':
      $("#Proyeccion").show();
      $("#tipo").val("proyeccion");
    break;
   case '2':
      $("#Proyeccion").show();
      $("#tipo").val("Real");
    break;
  }
});

$('#filtrosInventario').on('change',function () {
  var filtro=$('#filtrosInventario').val();
  switch(filtro){
    case '0':
    $('#partidas').hide();
    $('#materiales').hide();
    break;
    case '1':
    $('#partidas').show();
    $('#materiales').hide();
    break;
    case '2':
    $('#partidas').hide();
    $('#materiales').show();
    break;
  }
});

function mostrarContrasena(){
    var tipo = document.getElementById("password");
    if(tipo.type == "password"){
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        tipo.type = "text";
    }else{
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        tipo.type = "password";
    }
}
function mostrarPass(){
    var dato = document.getElementById("password_alt");
    if(dato.type == "password"){
      $('.icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        dato.type = "text";
    }else{
      $('.icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        dato.type = "password";
    }
}
function LoginPass(){
    var dato = document.getElementById("user_pass");
    if(dato.type == "password"){
      $('.icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        dato.type = "text";
    }else{
      $('.icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        dato.type = "password";
    }
}
  $('#selectPartidas').on('change', function(){
    var partida=$('#selectPartidas').val();
    // var id="IdDep";
    var model = $(this).data('model');

    $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          partida: partida
      },
      success: function (data) {
        $('#table_id1').dataTable().fnDestroy();
          $('.container-table').html(data);
          TableReload();
      }

    });
});
  $('#selectMaterial').on('change', function(){
    var material=$('#selectMaterial').val();
    // var id="IdDep";
    var model = $(this).data('model');

    $.ajax({
      url: url_request+model+'/search',
      type: 'POST',
       data: {
          model: model,
          function: 'Buscar',
          method: 'search',
          material: material
      },
      success: function (data) {
        $('#table_id1').dataTable().fnDestroy();
          $('.container-table').html(data);
          TableReload();
      }

    });
});
// mustra de unidad y precio, mas validacion de materiales
function adicionales(){
  var val = $('#material').val();
  var arrayMat = val.split("|");
  var html="<div class='col-sm-2'> <label class='col-form-label font-weight-bold'> </label>"+
    "</div><div class='col-sm-5'> <label class='col-form-label '> Unidad de Medida: "+arrayMat[2]+"</label>"+
    "</div> <div class='col-sm-4'> <label class='col-form-label '>"+'Precio: $'+arrayMat[3]+"</label></div>";
  var msg="<div class='col-sm-12 alert alert-danger' role='alert'>El material ya ha sido capturado en este proyecto </div>"
    $.ajax({
      url: url_request+'RequisicionAnual/validate',
      type: 'POST',
      cache: false,
      dataType: 'JSON',
       data: {
          model: 'RequisicionAnual',
          method: 'validate',
          function: 'validate',
          dep: $('#departamento').val(),
          anio: $('#anio').val(),
          material:arrayMat[0],
          proy: $('#proyecto').val()
      },
      success: function (data) {
        if(data){
              document.getElementById("up").innerHTML = msg;
              $('#send').attr("disabled", true)
        }else{
              document.getElementById("up").innerHTML = html;
              $('#send').attr("disabled", false)
        }
      }
    });


}

//funcion para asignar datatables al cambiar de departamento
$('#pages').on('change', function(){
  var opt=$('#pages').val();
  var model = $(this).data('model');
  var val = $(this).data('val');
  var cont = $(this).data('cont');

  $('#idUserUp').val(opt);

  $.ajax({
    url: url_request+model+'/search',
    type: 'POST',
     data: {
        model: model,
        function: 'Buscar',
        method: 'search',
        opt: opt,
        val:val,
        cont:cont
    },
    success: function (data) {
      $('#tableid1').dataTable().fnDestroy();
        $('.data-page').html(data);
        TableReload(1,'#tableid');
    }
  });

});

//asignar paginacion a tablas buscadas por jquery
function tables(val,proy,anio,model){
  val++
  var opt=$('#pages').val();
  $.ajax({
    url: url_request+model+'/onload',
    type: 'POST',
     data: {
        model: model,
        function: 'onload',
        method: 'onload',
        opt: opt,
        anio:anio,
        proy:proy
    },

    beforeSend: function () {
      $('.container-table').html(spinner);
      $('#pag-select').val(proy);
    },
    success: function (data) {
        $('#tableid'+val).dataTable().fnDestroy();
        $('.container-table').html(data);
        TableReload(val,'#tableid');
    }
  });

}
// [ tabs de interfaz de RBS solo funciona para el admin ]
if($('#tipouserAdmin').val() == 'SuperAdmin'){
  var firtsTabs='Enviadas-1';
  var tipo=firtsTabs;

 $tabButtons = $('.nav-item > a');
  var $tabsLinks  = $("#TabRBS li a");
    $tabButtons.click(function() {
      var valueselect=$('#selectDeptosRBS').val();
      tipo =$(this).attr('value');
      var numTabs;
      if(valueselect != '-1'){
      var arrayoption=tipo.split('-');
      numTabs=arrayoption[1];
      //alert(arrayoption[0]+' '+valueselect );
      $.ajax({
        url: url_request+'RBS'+'/tableReload',
        type: 'POST',
         data: {
            model: 'RBS',
            function: 'tableReload',
            method: 'tableReload',
            optionTabs: arrayoption[0],
            valueselect: valueselect
        },

        beforeSend: function () {
          $('.container-table').html(spinner);
        },
        success: function (data) {
            $('#tableid'+numTabs).dataTable().fnDestroy();
            $('#container-table'+numTabs).html(data);
            TableReload(numTabs,'#tableid');
        }
      });
      }

    });
    if(tipo!=''){
        $('#selectDeptosRBS').on('change', function(){
          var valueselect=$('#selectDeptosRBS').val();
          var numTabs;
          if(valueselect != '-1'){
            var arrayoption=tipo.split('-');
            numTabs=arrayoption[1];
          //alert(arrayoption[0] );
          $.ajax({
            url: url_request+'RBS'+'/tableReload',
            type: 'POST',
             data: {
                model: 'RBS',
                function: 'tableReload',
                method: 'tableReload',
                optionTabs: arrayoption[0],
                valueselect: valueselect
            },

            beforeSend: function () {
              $('.container-table').html(spinner);
            },
            success: function (data) {
                $('#tableid'+numTabs).dataTable().fnDestroy();
                $('#container-table'+numTabs).html(data);
                TableReload(numTabs,'#tableid');
            }
          });
          }
        });

    }

}




//para asignar datatables a pages de paa, cuenado sea buscado por el usuario administrador
  function TableReload(i,val) {
  var id=(val == '#tableid')?val:'#table_id';
  $(id+i).DataTable(
      {
            "pagingType": "full_numbers",
            "ordering": false,
            "searching": true,
            "paging": true,
            language: {
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible en esta tabla",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
              "sUrl":            "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     ">",
                  "sPrevious": "<"
              },
              "oAria": {
                  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
            }
        }
      );
}
  $(document).ready(function(){
    $(".toast").toast({autohide: false});
    $(".toast").toast("show");
  });
