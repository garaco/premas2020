<?php require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <?php
        $header = new header();
        $header->PushHeader('Requisiciones | Configuración General');
    ?>
    <script type="text/javascript">
      function viewPDF(url){
        window.open('C:/xampp/htdocs/premas/app/Manuales/MANUALDEUSUARIO-ADMINISTRADOR.pdf', '_blank');
      }
    </script>
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
              <a class="navbar-brand font-weight-bold text-white">CONFIGURACIÓN GENERAL</a>
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
      <div class="contentPage animate-des main" style="margin-top: 2px;">
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:50px;">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Global</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bitácora del sistema</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Exportar / Importar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual" role="tab" aria-controls="manual" aria-selected="false">Manuales</a>
          </li>          
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/configuraciones.png">
                    <label class="font-weight-bold">COFIGURACIÓN REQUISICIONES ANUALES</label>
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-1.5 p-3" >
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Configuracion" data-operation="Agregar" data-method="requested">
                         <span class="icon-plus-circle">Agregar</span>
                      </button>
                  </div>
                <!-- </div> -->
              </div>

            </div>
            <br>
            <div class="container border bg-white">
                <br>
                <!-- secion de tabla de datos  -->
                <div class="table-wrapper-scroll-y">
                  <div class="table table-responsive-sm table-responsive-md small" id="table">
                    <table class="table table-sm table-striped table-hover" id="table_id1">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Descripción</th>
                          <th scope="col">Fecha Inicio</th>
                          <th scope="col">Fecha Final</th>
                          <th scope="col">Días Restantes</th>
                          <th scope="col">Editar</th>
                        </tr>
                      </thead>
                      <tbody class="container-table" style="font-size: 12px;">
                        <?php foreach ($result as $r){ ?>
                        <tr>
                          <th scope="row"><?= utf8_encode($r['Descripcion']); ?></th>
                          <td><?=$r['FechaInicio']; ?></td>
                          <td><?= $r['FechaFinal']; ?></td>
                          <td><?= $r['Dias']; ?></td>
                          <td><center><button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r['IdConfiguracion'] ?>" data-model="Configuracion" data-operation="Editar" data-method="requested">
                                <span class="icon-pencil"></span></button></center></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
                    <label class="font-weight-bold">BITÁCORA DEL SISTEMA</label>
                </div>
              </div>

            </div>
            <br>
            <div class="container border bg-white">
                <br>
                <!-- secion de tabla de datos  -->
                <div class="table-wrapper-scroll-y">
                  <div class="table table-responsive-sm table-responsive-md small" id="table">
                    <table class="table table-sm table-striped table-hover" id="table_id2">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Usuario</th>
                          <th scope="col">Modulo</th>
                          <th scope="col">Accion</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Fecha</th>
                        </tr>
                      </thead>
                      <tbody class="container-table" style="font-size: 12px;">
                        <?php foreach ($Kardex as $r){ ?>
                        <tr>
                          <th scope="row"><?= utf8_encode($r['Usuario']); ?></th>
                          <td><?=$r['Catalogo']; ?></td>
                          <td><?= $r['Accion']; ?></td>
                          <td><?= $r['Descripcion']; ?></td>
                          <td><?= $r['Fechas']; ?></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/dbs.png">
                    <label class="font-weight-bold">EXPORTAR/IMPORTAR BASE DE DATOS</label>
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-1.5 p-3" >
                      <a href="<?php echo FOLDER_PATH ?>/Configuracion/Export" class="btn btn-success btn-lg active" style="float:right" role="button" aria-pressed="true">
                          <span class="fa fa-cloud-download"><label class="font-weight-bold"> Exportar Base de Datos</label> </span>
                      </a>
                  </div>
                  <div class="form-group col-sm-1.5 p-3" >
                    <button type="button" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Configuracion" data-name="Base de Datos" data-operation="Importar" data-method="Importar">
                         <span class="fa fa-cloud-upload"><label class="font-weight-bold"> Importar Base de Datos</label> </span>
                      </button>
                  </div>
              </div>
            </div>
            <br><br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/subir.png">
                    <label class="font-weight-bold">EXPORTAR/IMPORTAR TABLAS</label>
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-1.5 p-3" >
                      <button type="button" class="btn btn-success btn-lg " data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Configuracion" data-name="Catalogo" data-operation="Exportar" data-method="Exportar">
                           <span class="fa fa-download"><label class="font-weight-bold"> Exportar Tabla</label> </span>
                        </button>
                  </div>
                  <div class="form-group col-sm-1.5 p-3" >
                    <button type="button" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Configuracion" data-name="Excel" data-operation="Subir" data-method="Subir">
                         <span class="fa fa-upload"><label class="font-weight-bold"> Importar Tabla</label> </span>
                      </button>
                  </div>
              </div>
            </div>
            <br><br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                    <img src="<?php echo PATH_PUBLIC ?>/img/presupuesto.png">
                      <label class="font-weight-bold ">Costo por Partida </label>
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-1.5 p-3" >
                    <a href="<?php echo FOLDER_PATH ?>/Configuracion/costo" class="btn btn-success btn-lg active" style="float:right" role="button" aria-pressed="true">
                        <span class="fa fa-download"><label class="font-weight-bold"> Generar Costo PAA</label> </span>
                    </a>
                  </div>
                  <div class="form-group col-sm-1.5 p-3" >
                    <a href="<?php echo FOLDER_PATH ?>/Configuracion/consumido" class="btn btn-success btn-lg active" style="float:right" role="button" aria-pressed="true">
                        <span class="fa fa-download"><label class="font-weight-bold"> Generar Costo Consumido PAA</label> </span>
                    </a>
                  </div>
              </div>
            </div>

          </div>
          <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
            <br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/info.png">
                    <label class="font-weight-bold">INFORMACION SOBRE EL SISTEMA</label>
                </div>
              </div>
              <div class="container">
                <p style="text-align: justify;">
                  <br>
                  El presente software es de Requisiciones por autorizar, órdenes de compra, entradas y salidas de almacén, el cual lleva por nombre PREMAS.
                  Queda prohibido la copia de código o diseño de interfaces de este sistema, así como la copia o foto copia de la documentación.
                  El equipo encargado del desarrollo de este sistema web es:
                  Ing. Alejandro de Jesús García Acosta.
                  Ing. José Eduardo Chagala Martínez.
                  Ing. Juan Carlos Ambros Marcial.
                  Además del apoyo del asesor interno: M.T.I. Angelina Márquez Jiménez y el asesor externo: Lic. Eyroce Iván Bustamante Chagala.
                  Por ello cualquier modificación o ajuste al sistema en la parte de programación tiene que ser autorizada
                  por los miembros del equipo de este proyecto, o en su caso llamarlos para realizar dichas modificaciones.
                  El desarrollo de este sistema es único y exclusivo para el Instituto Tecnológico Superior de San Andrés Tuxtla.

                  A continuación se les otorga los enlaces para la descarga de los manuales de usuarios.

          </p>

              </div>
            </div>
            <br>
          </div>
          <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
            <br>
            <div class="container border bg-white">
              <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                  <img src="<?php echo PATH_PUBLIC ?>/img/info.png">
                    <label class="font-weight-bold">MANUALES DEL SISTEMA</label>
                </div>
              </div>
              <div class="container">
                <br>
              <div class="row">
                  <div class="form-group col-sm-4 p-3" >
                    <form method="post" action="<?php echo  FOLDER_PATH?>/Configuracion/viewPDF">
                      <input type="hidden" name="url" value="<?php echo ROOT . FOLDER_PATH .'/'. PATH_MANUAL?>MANUALDEUSUARIO-ADMINISTRADOR.pdf">
                      <input type="hidden" name="filename" value="Administrador">
                        <div class="card border-primary ">
                          <div class="card-header bg-primary text-white">
                            <h5>Manual Usuario Administrador</h5>
                            
                          </div>
                          <div class="card-body">
                            <center>
                              <button type="submit" class="btn btn-success"> <span class="fa fa-download"></span> Descargar
                              </button>                                   
                            </center>
    
                          </div>
                        </div>
                    </form>
                  </div>
                  <div class="col-sm-4 p-3" >
                    <form method="post" action="<?php echo  FOLDER_PATH?>/Configuracion/viewPDF">
                      <input type="hidden" name="url" value="<?php echo ROOT . FOLDER_PATH .'/'. PATH_MANUAL?>MANUALDEUSUARIO-DEPARTAMENTOS.pdf">
                      <input type="hidden" name="filename" value="Departamento">
                        <div class="card border-primary ">
                          <div class="card-header bg-primary text-white">
                            <h5>Manual Usuario Departamento</h5>
                            
                          </div>
                          <div class="card-body">
                            <center>
                              <button type="submit" class="btn btn-success"> <span class="fa fa-download"></span> Descargar
                              </button>                                   
                            </center>
    
                          </div>
                        </div>
                    </form>

                  </div>
                  <div class="form-group col-sm-4 p-3" >
                    <form method="post" action="<?php echo  FOLDER_PATH?>/Configuracion/viewPDF">
                      <input type="hidden" name="url" value="<?php echo ROOT . FOLDER_PATH .'/'. PATH_MANUAL?>MANUALDEUSUARIO-DIRECTOR.pdf">
                      <input type="hidden" name="filename" value="DireccionGeneral">
                        <div class="card border-primary ">
                          <div class="card-header bg-primary text-white">
                            <h5>Manual Usuario Dirección Gral.</h5>
                          </div>
                          <div class="card-body">
                            <center>
                              <button type="submit " class="btn btn-success"> <span class="fa fa-download"></span> Descargar
                              </button>                                   
                            </center>
    
                          </div>
                        </div>
                    </form>                    

                  </div>                  
              </div>
              </div>
            </div>
            <br>
          </div>          
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
    </div>

  </main>
    <input type="hidden" id="num_tabla" value="2">
</body>

<?php require_once SCRIPTS; ?>
</html>
