<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Download free responsive login form,sign-up form,responsive templates">
    <title>Ingreso</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>/css/styleLogin.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>/boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>/font-awesome/css/font-awesome.css">
    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>/img/logo1.png">
  </head>

  <body>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">

        <!-- LOGIN MODULE -->
        <div class="login">
            <div class="wrap">
                <!-- TOGGLE -->
                <div id="toggle-wrap">
                    <div id="toggle-terms">
                        <div id="cross">

                        </div>
                    </div>
                </div>

                <!-- SLIDER -->
                <div class="content">
                    <!-- SLIDESHOW -->
                    <div id="slideshow">
                        <img src="<?php echo PATH_PUBLIC ?>/img/logo.png" alt="">
                        <h3 id="nameTitle">P R E M A S</h3>

                    </div>
                </div>
                <!-- LOGIN FORM -->
                <div class="user">

                    <div class="form-wrap">
                        <!-- TABS -->
                    	<div class="tabs">
                            <h3 class="login-tab"><a class="log-in active"><span>Ingreso<span></a></h3>
                    	</div>
                        <!-- TABS CONTENT -->
                    	<div class="tabs-content">
                            <!-- TABS CONTENT LOGIN -->
                    		<div id="login-tab-content" class="active">
                    			<form class="login-form" method="POST" action="<?= FOLDER_PATH . '/Login/signin' ?>">
                    				<input type="text" class="input" id="user_login" autocomplete="off" placeholder="Usuario" name="email">
                    				<input type="password" class="input" id="user_pass" autocomplete="off" placeholder="Contraseña" name="password">
                            <button type="button" name="button" class="ver" onclick="LoginPass()" > <span class="fa fa-eye icon2"></span> </button>
                    				<input type="submit" class="button" value="Ingresar">
                    			</form>
                    		</div>
                        <br><br>
                        <div aling="center">
                          <a style="text-decoration: none" href="#" data-toggle="modal" data-target="#ventana" data-id="0" data-model="Login" data-operation="Recuperar" data-method="Recover"><font size="2">¿Olvidaste tu contrseña?</font></a>
                        </div>
                      </div>
                	</div>
                 <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" id="success-alert" role ="alert">
                    <strong><span class="fa fa-user-times fa-3"></span><label ><?=isset($error_message)?$error_message:''?></label></strong>
                     </div>

                <?php } if (isset($success_message)) { ?>
                  <div class="alert alert-success alert-dismissible fade show text-center" id="success-alert" role ="alert">
                  <strong><span class="fa fa-envelope-o fa-3"></span><label ><?=isset($success_message)?$success_message:''?></label></strong>
                   </div>

                <?php } ?>
                </div>
            </div>

        </div>


        </div>
      </div>

    </div>
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
<?php require_once SCRIPTS; ?>
  </body>

</html>
