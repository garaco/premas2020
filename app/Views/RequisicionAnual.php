<?php
require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
static $conAll=0;
static $pagproy='';
$req = new RequisicionAnualModel();
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
<?php
        $header = new header();
        $header->PushHeader('Gestion de Requisiciones');

?>
</head>
    <body class="Colorpage" onload="myFunction()" style="margin:0;">
    <main id="wrapper">
     <?php require_once SIDERBAR; ?>
     <div id="loader"> </div>
      <nav class="navbar navbar-expand navbar-dark  navbar-light justify-content colornavbar" style="padding: 0px; padding-left: 30px;">
       <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <!-- validacion para los datos del navar de acuero al tipo de user -->
           <li class="nav-item active">
             <?php if ($area <> 'SuperAdmin') { ?>
              <img style="padding: 5px 5px; width: 50px; height: 50px;"src="<?php echo PATH_PUBLIC ?>\img\logo.png">
            <?php } else if ($area == 'SuperAdmin'){ ?>
              <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
              <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
            <?php } else if ($area == 'SCM'){ ?>
              <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
              <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
            <?php } ?>
              <a class="navbar-brand font-weight-bold text-white" style="font-size: 15px;" >PROGRAMA ANUAL DE REQUISICIONES / <?= $dep; ?> </a>
           </li>
       </ul>
       <div class="dropdown" style="padding-right: 30px;">
         <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
           <span class="fa fa-user-circle"></span> <label > <?=$User?></label>
         </button>
       <div class="dropdown-menu dropdown-menu-right">
         <?php if ($area == 'Normal') { ?>
           <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RBS" ><span class="fa fa-address-card-o"> </span> Alta Requisiciones</a>
           <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RequisicionAnual" ><span class="fa fa-calendar-o"> </span> Programa Anual Requisiciones</a>
           <div class="dropdown-divider"></div>
         <?php } else if($area == 'SCM') { ?>
           <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/SMC" ><span class="fa fa-address-card-o"> </span> Alta Solicitud Mantenimiento</a>
           <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RequisicionAnual" ><span class="fa fa-calendar-o"> </span> Programa Anual Requisiciones</a>
           <div class="dropdown-divider"></div>
         <?php } ?>
         <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
       </div>
       </div>
     </div>
   </nav>
   <!-- cycle to show all existing tabs -->
   <div id="" class="animate-des">
     <div class="contentPage" style="margin-top: 2px;">
       <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:50px;">
         <?php $indice=0; $i=0; $i_auxAnio=0;//i_auxAnio para el indice para el arrayAnios
         $arrayAnios = array();
          foreach ($Anio as $a){
            $arrayAnios[$i]=$a['Anio'];
            $i++;
           if($a['Anio']== date('Y')){ $indice++;
           ?>
           <li class="nav-item">
             <a class="nav-link" id="static-tab" data-toggle="tab" href="#static" role="tab" aria-controls="static" aria-selected="false">Programa Anual Requisicones <strong> <?= $a['Anio'];?></strong></a>
           </li>
         <?php }else if($a['Anio']== (date('Y')+1)){ $indice++;?>
           <li class="nav-item">
             <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="true">Programa Anual Requisicones <strong ><?= $a['Anio']; ?></strong> .
               <span class="badge pull-right bg-danger text "> <i class="fa fa-star"> </i></span>
             </a>
           </li>
         <?php } }?>
       </ul>
<!-- Primera pagina -->
<!-- cintiene la pagina del nuevo año que se va a capturar el PAA -->
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade <?= ($indice==2) ? 'show active' : '';  ?>" id="new" role="tabpanel" aria-labelledby="new-tab">
  <?php $isTrueNew=False; foreach ($kardex as $v){if($v['Dias']>0 and $v['Anio']== (date('Y')+1)){$isTrueNew=True;}}?>
    <br>
        <div class="container-fluid">
          <div class="container-fluid border bg-white" id="container-fluid-pago">
            <div class="row justify-content-md-center">
              <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
                  <label class="font-weight-bold" style="font-weight:bold;"> ALTA REQUISICIONES ANUALES </label>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-1.5 p-3" >
                <?php if($isTrueNew and $area <> 'SuperAdmin'){ ?>
                <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-anio="<?= (date('Y')+1); ?>" data-model="RequisicionAnual" data-operation="Agregar" data-method="requested">
                          <span class="icon-plus-circle">Agregar</span>
                </button>
              <?php }?>
              </div>
          <div class="col-sm-1.5 p-4" >
            <label>Exportar PDF:</label>
          </div>
          <!-- select para el PAA  -->
          <div class="col-sm-1.5 p-3" >
                <select class="form-control badge" name="PrintPDF" id="paaOld" data-model="RequisicionAnual">
                <option value="0" >Selecione....</option>
                <option value="1" >Programa Anual Inicial</option>
                <option value="2" >Programa Anual Actual</option>
            </select>
          </div>
          <!-- campos necesarios para imprimir el PAA -->
          <div class="col-sm-1.5">
            <form action="<?php echo FOLDER_PATH?>/Visualiza/pdf" method="POST" style="display: none;" id="Proyeccion" target="_blank">
              <input type="hidden" name="num" value="PDFreqAnual">
              <input type="hidden" name="tipo" value="proyeccion">
              <input type="hidden" name="anio" id="tipo" value="<?= date('Y')+1; ?>">
              <input type="hidden" name="dep" id="TdepN" value="">
              <br>
            <div class="row" >
              <br>
              <div class="col-sm-12">
              <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-download"></i> Exportar</button>
              </div>

              </div>

            </form>
            </div>
            <div class="col-sm-3">

            </div>
            </div>

          </div>
          <!-- ciclo para mostrar los proyectos de cada departamento  -->
          <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:50px;">
            <?php
            $cont=0; foreach ($ProyecNew as $p){  ?>
              <li class="nav-item">
                <a class="nav-link <?php if($cont==0) { echo 'active'; } ?> " id="new-tab-<?= $cont;  ?>" data-toggle="tab" href="#new-<?= $cont;  ?>" role="tab"
                  aria-controls="new-<?= $cont;  ?>" aria-selected="true" onclick="tables(<?= $cont;?>,<?= $p['IdProyecto'];?>,<?php (date('Y')+1); ?>,'RequisicionAnual')">
                  <?= $p['nProyecto']; ?>
                </a>
              </li>
            <?php $cont++; } ?>

          </ul>
          <!-- carga todas las tablas de acuerdo al proyecto -->
          <div class="tab-content" id="myTabContent">
            <?php $cont=0;  foreach ($ProyecNew as $p){ $conAll++;
              ($conAll==1)?$pagproy=$p['IdProyecto']:'';
               $explode = explode("-", utf8_encode($p['Proy']));
               $resultados=$req->getReqDep($p['IdUsuario'],(date('Y')+1),$p['IdProyecto']);
              ?>
            <div class="tab-pane fade <?= ($cont==0) ? 'show active' : '';  ?>" id="new-<?= $cont;  ?>" role="tabpanel" aria-labelledby="new-tab-<?= $cont;  ?>">
              <label class="col-sm-12 col-form-label h2" style="font-weight:bold;"><?= $explode[0]; ?></label>
            <div class="container-fluid border" id="container-fluid-pago">
              <br>
              <div class="table table-bordered table-responsive-sm table-responsive-md small" >
                <table class="table table-sm table-striped table-hover" id="tableid<?= $conAll;?>">
                  <thead class="thead-dark">
                    <tr>
                      <th rowspan="2" scope="col" class="text-center">Proyecto</th>
                      <th rowspan="2" scope="col" class="text-center">Meta</th>
                      <th rowspan="2" scope="col" class="text-center">Partida</th>
                      <th rowspan="2" scope="col" class="text-center">Descipcion del Articulo</th>
                      <th rowspan="2" scope="col" class="text-center">Unidad de Medida</th>
                      <th rowspan="2" scope="col" class="text-center">Precio Unitario</th>
                      <th colspan="12" scope="col" class="text-center">Cantidad Mensual</th>
                      <th colspan="2" class="text-center">Total</th>
                      <?php if($isTrueNew or $area == 'SuperAdmin'){ ?><th colspan="2" class="text-center"></th><?php } ?>
                    </tr>
                    <tr>
                      <th scope="col" class="text-center">Ene</th>
                      <th scope="col" class="text-center">Feb</th>
                      <th scope="col" class="text-center">Mar</th>
                      <th scope="col" class="text-center">Abr</th>
                      <th scope="col" class="text-center">May</th>
                      <th scope="col" class="text-center">Jun</th>
                      <th scope="col" class="text-center">Jul</th>
                      <th scope="col" class="text-center">Ago</th>
                      <th scope="col" class="text-center">Sep</th>
                      <th scope="col" class="text-center">Oct</th>
                      <th scope="col" class="text-center">Nov</th>
                      <th scope="col" class="text-center">Div</th>
                      <th scope="col" class="text-center">Cantidad</th>
                      <th scope="col" class="text-center">Precio</th>
                      <?php if($isTrueNew or $area == 'SuperAdmin'){ ?><th scope="col" class="text-center"></th><?php } ?>
                    </tr>
                  </thead>
                  <tbody class="container-table">
                    <?php foreach ($resultados as $r) {?>
                    <tr>
                      <td class="small text-justify"> <?= $r->Proyectos;?></td>
                      <td class="small text-justify"> <?= $r->Metas;?></td>
                      <td class="small text-justify"> <?= $r->Partida;?></td>
                      <td class="small text-justify"><?= $r->Articulo; ?> </td>
                      <td class="text-center"><?= $r->UnidadMedida; ?></td>
                      <td class="text-center"><?= $r->PU; ?></td>
                      <td class="text-center"><?= $r->Ene;?></td>
                      <td class="text-center"><?= $r->Feb; ?> </td>
                      <td class="text-center"><?= $r->Mar; ?> </td>
                      <td class="text-center"><?= $r->Abr; ?> </td>
                      <td class="text-center"><?= $r->May; ?> </td>
                      <td class="text-center"><?= $r->Jun; ?> </td>
                      <td class="text-center"><?= $r->Jul; ?> </td>
                      <td class="text-center"><?= $r->Ago; ?> </td>
                      <td class="text-center"><?= $r->Sep; ?> </td>
                      <td class="text-center"><?= $r->Oct; ?> </td>
                      <td class="text-center"><?= $r->Nov; ?> </td>
                      <td class="text-center"><?= $r->Dic; ?> </td>
                      <td class="text-center"><?= $r->Cantidad; ?> </td>
                      <td class="text-center"><?= "$".$r->Total; ?> </td>
                        <?php if($isTrueNew or $area == 'SuperAdmin'){ ?>
                        <td>
                        <center>
                          <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= (date('Y')+1); ?>" data-model="RequisicionAnual" data-operation="Editar" data-method="requested" >
                            <span class="icon-pencil"></span>
                          </button>
                        </center>
                                          <center>
                      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= (date('Y')+1); ?>" data-model="RequisicionAnual" data-operation="Eliminar" data-method="delete" >
                        <span class="icon-trash"></span>
                      </button>
                    </center>
                        </td>
                      <?php } ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
               </div>
              </div>
              </div>
              <?php $cont++; }?>
          </div>

          </div>
  </div>
<!-- segunda pagina -->
<!-- tab del PAA del año actual -->
 <div class="tab-pane fade <?= ($indice==1) ? 'show active' : '';  ?>" id="static" role="tabpanel" aria-labelledby="static-tab">
<br>
<?php $isTrue=False; foreach ($kardex as $v){if($v['Dias']>0 and $v['Anio']== date('Y')){$isTrue=True;}}?>
    <div class="container-fluid">
      <div class="container-fluid border bg-white" id="container-fluid-pago">
        <div class="row justify-content-md-center">
          <div class="col-sm-12 alert-color">
              <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
              <label class="font-weight-bold" style="font-weight:bold;"> ALTA REQUISICIONES ANUALES </label>
          </div>
        </div>
        <!-- validacion si es SuperAdmin se habilita un selec con todos los departamentos -->
        <!-- sino se pone el boton aceptar -->
        <div class="row">
          <?php if($isTrue or $area == 'SuperAdmin'){ ?>
          <div class="col-sm-1.5 p-3" >
            <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-anio="<?= date('Y'); ?>"  data-model="RequisicionAnual" data-operation="Agregar" data-method="requested">
                      <span class="icon-plus-circle">Agregar</span>
            </button>
          </div>
          <?php } if($area == 'SuperAdmin'){?>
            <div class="col-sm-1.5 p-3" >
            <select class="form-control badge badge-default" id="pages" data-model="RequisicionAnual" data-val="<?= $isTrue ?>" data-cont="<?= $conAll ?>">
              <option value="22" >RECURSOS MATERIALES</option>
              <?php  $depa = new DepartamentoModel(); $depa= $depa->allDepartamento();?>
              <?php foreach ($depa as $d) {?>
              <option value="<?=$d['idDepart']?>"> <?=$d['nombreDepto'];?></option>
              <?php }?>
            </select>
            </div>
          <?php } ?>
          <div class="col-sm-1.5 p-4" >
            <label>Exportar PDF:</label>
          </div>
          <div class="col-sm-1.5 p-3" >
            <select class="form-control badge" name="PrintPDF" id="paaNew" data-model="RequisicionAnual">
                <option value="0" >Selecione....</option>
                <option value="1" >Programa Anual Inicial</option>
                <option value="2" >Programa Anual Actual</option>
            </select>
          </div>
          <div class="col-sm-1.5">
            <form action="<?php echo FOLDER_PATH?>/Visualiza/pdf" method="POST" style="display: none;" id="Proyeccion2" target="_blank">
              <input type="hidden" name="num" value="PDFreqAnual">
              <input type="hidden" name="tipo" id="tipo2" value="">
              <input type="hidden" name="anio" value="<?= date('Y'); ?>">
              <input type="hidden" name="dep" id="Tdep" value="">
              <br>
            <div class="row" >
              <br>
              <div class="col-sm-12">
              <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-download"></i> Exportar</button>
              </div>

              </div>

            </form>

            </div>
            <form action="<?php echo FOLDER_PATH?>/RequisicionAnual/Refrehs" method="POST">
              <br>
              <input type="hidden" name="idUserUp" id="idUserUp" value="0">
              <input type="hidden" name="anioUp" id="anioUp" value="<?= date('Y'); ?>">
              <div class="row">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-refresh"></i> Actualiza Material al Mes Actual</button>
                </div>
              </div>
            </form>
        </div>

      </div>
      <div class="data-page" role="tabpanel">
        <!-- tabs de los proyectos -->
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:20px;">
          <?php $cont=0; foreach ($proyectos as $p){ ?>
            <li class="nav-item">
              <a class="pag_nav nav-link <?php if($cont==0) { echo 'active'; } ?> " id="ant-tab-<?= $cont; ?>" data-toggle="tab" href="#ant-<?= $cont;  ?>"
                role="tab" aria-controls="ant-<?= $cont;  ?>" aria-selected="true" onclick="tables(<?= $cont;?>,<?= $p['IdProyecto'];?>,<?= date('Y'); ?>,'RequisicionAnual')"
                >
                <?= $p['nProyecto']; ?>
              </a>
            </li>
          <?php $cont++; } ?>
        </ul>
        <!-- datos de tablas de acuerod a cada proyecto -->
        <div class="tab-content" id="myTabContent">
          <?php
            $cont=0;
          foreach ($proyectos as $p){ $conAll++;
            ($conAll==1)?$pagproy=$p['IdProyecto']:'';
             $explode = explode("-", $p['Proy']);
             $resultados=$req->getReqDep($p['IdUsuario'],date('Y'),$p['IdProyecto']);
            ?>
          <div class="tab-pane fade <?= ($cont==0) ? 'show active' : '';  ?>" id="ant-<?= $cont;  ?>" role="tabpanel" aria-labelledby="ant-tab-<?= $cont;  ?>">
            <label class="col-sm-12 col-form-label h2" style="font-weight:bold;"><?= $explode[0]; ?></label>
          <div class="container-fluid border" id="container-fluid-pago">
            <br>
            <div class="table table-bordered table-responsive-sm table-responsive-md small" >
              <table class="table table-sm table-striped table-hover" id="tableid<?= $conAll;?>">
                <thead class="thead-dark">
                  <tr>
                    <th rowspan="2" scope="col" class="text-center">Proyecto </th>
                    <th rowspan="2" scope="col" class="text-center">Meta</th>
                    <th rowspan="2" scope="col" class="text-center">Partida</th>
                    <th rowspan="2" scope="col" class="text-center">Descipcion del Articulo</th>
                    <th rowspan="2" scope="col" class="text-center">Unidad de Medida</th>
                    <th rowspan="2" scope="col" class="text-center">Precio Unitario</th>
                    <th colspan="12" scope="col" class="text-center">Cantidad Mensual</th>
                    <th colspan="2" class="text-center">Total</th>
                    <?php if($isTrueNew or $area == 'SuperAdmin'){ ?><th colspan="2" class="text-center"></th><?php } ?>
                  </tr>
                  <tr>
                    <th scope="col" class="text-center">Ene</th>
                    <th scope="col" class="text-center">Feb</th>
                    <th scope="col" class="text-center">Mar</th>
                    <th scope="col" class="text-center">Abr</th>
                    <th scope="col" class="text-center">May</th>
                    <th scope="col" class="text-center">Jun</th>
                    <th scope="col" class="text-center">Jul</th>
                    <th scope="col" class="text-center">Ago</th>
                    <th scope="col" class="text-center">Sep</th>
                    <th scope="col" class="text-center">Oct</th>
                    <th scope="col" class="text-center">Nov</th>
                    <th scope="col" class="text-center">Div</th>
                    <th scope="col" class="text-center">Cantidad</th>
                    <th scope="col" class="text-center">Precio</th>
                    <?php if($isTrueNew or $area == 'SuperAdmin'){ ?><th scope="col" class="text-center"></th><?php } ?>
                  </tr>
                </thead>
                <tbody class="container-table">
                  <?php foreach ($resultados as $r) {?>
                  <tr>
                    <td class="small text-justify"> <?= $r->Proyectos;?></td>
                    <td class="small text-justify"> <?= $r->Metas;?></td>
                    <td class="small text-justify"> <?= $r->Partida;?></td>
                    <td class="small text-justify"><?= $r->Articulo; ?> </td>
                    <td class="text-center"><?= $r->UnidadMedida; ?></td>
                    <td class="text-center"><?= $r->PU; ?></td>
                    <td class="text-center"><?= $r->Ene;?></td>
                    <td class="text-center"><?= $r->Feb; ?> </td>
                    <td class="text-center"><?= $r->Mar; ?> </td>
                    <td class="text-center"><?= $r->Abr; ?> </td>
                    <td class="text-center"><?= $r->May; ?> </td>
                    <td class="text-center"><?= $r->Jun; ?> </td>
                    <td class="text-center"><?= $r->Jul; ?> </td>
                    <td class="text-center"><?= $r->Ago; ?> </td>
                    <td class="text-center"><?= $r->Sep; ?> </td>
                    <td class="text-center"><?= $r->Oct; ?> </td>
                    <td class="text-center"><?= $r->Nov; ?> </td>
                    <td class="text-center"><?= $r->Dic; ?> </td>
                    <td class="text-center"><?= $r->Cantidad; ?> </td>
                    <td class="text-center"><?= "$".$r->Total; ?> </td>
                      <?php if($isTrueNew or $area == 'SuperAdmin'){ ?>
                      <td>
                      <center>
                        <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Editar" data-method="requested" >
                          <span class="icon-pencil"></span>
                        </button>
                      </center>
                  <center>
                    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Eliminar" data-method="delete" >
                      <span class="icon-trash"></span>
                    </button>
                  </center>
                      </td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
             </div>
            </div>
            </div>
            <?php $cont++; } ?>
            <input type="hidden" id="pag-select" value="<?= $pagproy; ?>">
        </div>
      </div>
       </div>
      </div>
      </div>
      <input type="hidden" id="num_tabla" value="<?= $conAll; ?>">
     </div>
    </div>
<!-- ventana modal -->
    <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-white"> </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
          </div>
          <!-- body de la venatan -->
        <div class="modal-body">

        </div>
        </div>
      </div>
    </div>
<!-- notificaciones -->
    <?php
    foreach ($kardex as $v){
      if($v['Dias']>0){
      ?>
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top:45px; right:10px; box-shadow: 2px 2px 10px #666;">
        <div class="toast-header">
          <label class="mr-auto font-weight-bold text-primary h6">Notificaciones</label>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          <label class="h6"> <?php echo utf8_encode($v['Descripcion']); ?></label>
        </div>
    </div>
  <?php } }?>
   </main>
  </body>
  <?php require_once 'scripts.php'; ?>
</html>
