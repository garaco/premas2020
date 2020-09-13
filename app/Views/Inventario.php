<?php
 require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <?php
        $header = new header();
        $header->PushHeader('EXISTENCIAS');
    ?>

  </head>

  <body class="Colorpage" onload="myFunction()" style="margin:0;">

    <!-- loader -->
    <div id="loader"></div>
    <!-- end loader -->
  <main id="wrapper">
     <?php require_once SIDERBAR; ?>
     <div id="page-content-wrapper">
       <nav class="navbar navbar-dark colornavbar">
         <div class="container-fluid">
           <div class="navbar-header">
             <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
             <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
             <a class="navbar-brand font-weight-bold text-white" >EXISTENCIAS DE MATERIALES</a>
           </div>
           <div class="col-sm-5" >
               <label class="sr-only">Buscar</label>
               <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar" id="buscar" data-model="Inventario" autocomplete="off">
             </div>
           <div class="dropdown ">
            <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
           <span class="fa fa-user-circle"></span> <label > <?=$User?></label>
           </button>
             <div class="dropdown-menu dropdown-menu-right">
                 <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
             </div>
           </div>
         </div>
       </nav>
    <div class="contentPage animate-des main">

      <br>
      <div class="container border bg-white">
        <div class="row justify-content-md-center">
          <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/material.png">
              <label class="font-weight-bold">INVENTARIO</label>
          </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-2"><br>
               <div class="input-group input-group-sm">
                 <div class="input-group-prepend ">
                   <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
                 </div>
                <select class="form-control badge badge-default " id="filtrosInventario" name="filtros" data-model="Material" style="font-size: 12px;">
                   <option value="0">Seleccione</option>
                   <option value="1">Partida</option>
                   <option value="2">Material</option>
                 </select>
               </div>
            </div>
            <div class="col-sm-4">
              <br>
              <div style="display: none;" id="partidas">
                <select class="form-control form-control-sm badge badge-default" id="selectPartidas" data-model="Inventario">
                  <option>Seleccione Partida</option>
                  <?php
                  $partida= new PartidasModel();
                  $Partidas=$partida->getAll('IdPartida');
                  foreach ($Partidas as $pt) {
                   ?>
                  <option value="<?=$pt['IdPartida']?>"><?=$pt['Codigo']?></option>
                  <?php } ?>
                </select>
              </div>
              <div style="display: none;" id="materiales">
                <select class="form-control badge badge-default " id="selectMaterial" data-model="Inventario">
                  <option value="0">Seleccione Material</option>
                  <?php
                  $material = new MaterialModel();
                  $Materiales = $material->getAll('IDmaterial');
                  foreach ($Materiales as $mt) {
                 ?>
                  <option value="<?=$mt['IDmaterial']?>"><?=$mt['Concepto']?></option>
                  <?php  } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4 text-right" >
              <br>

                Exportar PDF
                <select class="badge" name="ExportarPDF" id="ExportarPDF" data-model="Material">
                  <option value="0">Selecione</option>
                  <option value="1">Materiales en existencia</option>
                  <option value="2">Materiales entregados</option>

                </select>

            </div>
            <div class="col-sm-2">
              <form action="<?php echo FOLDER_PATH?>/Visualiza/pdf" method="POST" style="display: none;" id="RangoFecha" target="_blank">
                <input type="hidden" name="num" value="PDFinventario">
                <input type="hidden" name="tipo" value="entregados">
                <br>
              <div class="row" >
                <br>
                <div class="col-sm-12">
                <button type="submit" class="btn btn-sm btn-success" id="button"><i class="fa fa-download"></i> Exportar</button>
                </div>

                </div>

              </form>
              <form action="<?php echo FOLDER_PATH?>/Visualiza/pdf" method="POST" style="display: none;" id="all" target="_blank">
                <input type="hidden" name="num" value="PDFinventario">
                <input type="hidden" name="tipo" value="todo">
                <br>
                <div class="row">
                  <div class="col-sm-12">
                <button type="submit" class="btn btn-sm btn-success" id="button" ><i class="fa fa-download"></i> Exportar</button>
                  </div>
                </div>

              </form>
              </div>


            </div>

          <!-- </div> -->
        </div>

      <br>
      <div class="container border bg-white" >

          <!-- INICIO DE FORMULARIO -->
              <!-- ventana Modal -->
              <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
                <div class="modal-dialog" role="document">
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

        <div class="row justify-content-md-center">
          <div class="col-sm-12">
            <label class=" form-control text-center font-weight-bold" style="border: white;">
              <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">LISTA DE MATERIALES</label>
          </div>
        </div>
        <hr style="border-color: green; margin: 0; padding: 5px;">
        <br>
          <!-- secion de tabla de datos  -->
          <div class="table-wrapper-scroll-y">
            <div class="table table-responsive-sm table-responsive-md small" >
              <table class="table table-sm table-striped table-hover" id="table_id1">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Concepto</th>
                    <th scope="col" class="text-center">Unidad de Medida</th>
                    <th scope="col">Partida</th>
                    <th scope="col" class="text-center">Existencia</th>
                  </tr>
                </thead>
                <tbody class="container-table" style="font-size: 12px;">
                  <?php foreach ($result as $r){ ?>
                  <tr>
                    <th scope="row"><?= $r["Concepto"]; ?></th>
                    <td class="text-center"><?= $r["Medida"]; ?></td>
                    <td><?= $r["Codigo"]; ?></td>
                    <td class="text-center"><div <?=($r['Existencia'] == 0)?'style="background: #f00024; font-size: 14px; color: white; border-radius: 5px; font-weight: bold; width: 50px;"':'style="background: #00cc4b; font-size: 14px; color: white; border-radius: 5px; font-weight: bold; width: 50px;"'?>><?= $r['Existencia']?></div></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>

        <br>
  </div>
    </div>

  </main>
</body>
<?php require_once SCRIPTS; ?>

</html>
