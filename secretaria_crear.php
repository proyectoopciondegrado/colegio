<?php 
  require ("../models/models_admin.php");
  date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../templates/AdminLTE-3.0.5/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../templates/AdminLTE-3.0.5/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../templates/AdminLTE-3.0.5/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="../CSS/style.css" rel="stylesheet">
</head>

<!--class="sidebar-collapse sidebar-mini" -->

<body>

    <?php include "includes2/config.php"; ?>

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>" id="header">
            <?php 
      include "includes2/header.php";
    ?>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4" id="lateral">
            <?php 
    include "includes2/lateralaside.php";
     ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="fondo">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 align="right">Bienvenido</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content" id="fondo">

                <div class="row">
                     <!-- este div es para centrar el formulario -->
                    <div class="col-md-2">
                            
                    </div>

                    <!-- COLUMNA DE FORMULARIO  -->
                    <div class="col-md-8">
                        <!-- columna de contenido -->
                        <!-- /.card-header -->
                        <div class="card">
                            <div class="card-header bg-primary" class="Sub">
                                <h3 class="card-title">Formulario de registro </h3>
                            </div>
                            <!-- Para controles de formularios siempre usar etiqueta FORM -->

                            <?php 
            if(isset($_POST["txt_nombresec"])){//verificar la existencia de envio de datos
         // estas variables se utilizan a la hora de insertar datos en la base de datos en la variable ejecucion
              $idsec = $_POST["txt_idsec"];
              $nombresec = $_POST["txt_nombresec"];
              $email = $_POST["txt_email"];
              $dire = $_POST["txt_direccion"];
              $ciu = $_POST["txt_ciudad"];
              $telf = $_POST["txt_telfefeno"];
              $contrasena = sha1 ($_POST["txt_contrasena"]);



              //Verificamos que el usuario halla seleccionado archivos
              //y se procede a subir al servidor y elazarlo a la base de datos    
              $ext =""; $msgfile = ""; $logError="";
              if(isset($_FILES["txt_File"]['name']) && $_FILES["txt_File"]['name']!=null ){           
                $extens = array('.jpeg'=>'JPEG','.JPEG'=>'JPEG','.jpg' => 'JPG', '.png' => 'PNG', '.JPG' => 'JPG', '.PNG' => 'PNG');
                $ext = strrchr(basename($_FILES["txt_File"]['name']),".");        
                if($extens[$ext]){            
                  if($_FILES["txt_File"]['error'] == UPLOAD_ERR_OK ){ //Si el archivo se paso correctamente Continuamos 
                    $fotop = "imgs/clientes/";
                    $postname = date("Y").date("m").date("d")."_".date("H").date("i");
                    $fullname = explode(".",basename($_FILES["txt_File"]['name'])); // variabe temporal para sacar el nombre y separarlo de la extension
                    $NombreOriginal = $fullname[0];//Obtenemos el nombre original del archivo
                    $temporal = $_FILES["txt_File"]['tmp_name']; //Obtenemos la ruta Original del archivo
                    $Destino = "../".$fotop.$NombreOriginal."_".$postname.$ext; //Creamos una ruta de destino con la variable ruta y el nombre original del archivo 
                    $fotop = $fotop.$NombreOriginal."_".$postname.$ext; //Esto se guarda en el campo imagend e la base de dato
                    if(copy($temporal, $Destino)){ //Movemos el archivo temporal a la ruta especificada               
                      $msgfile = "Imagen subida.";
                    }else{
                      $msgfile .= "<span class='label label-danger'>la imagen del Producto .</span>";
                      $logError = "No se pudo subir la imagen del Producto, puede ser por tamaño. \n";
                    }  
                  }else{
                    $msgfile .= "<span class='label label-danger'>Error al transferirse el archivo.</span> ";
                  }

                }else{
                  $msgfile .= "<span class='label label-danger'><i class='fa fa-file-o'></i> Por seguridad se bloqueo el envío del archivo con extension no permitida [$ext].</span>"  ;  
                  $logError .="Por seguridad se bloqueo el envío del archivo con extension no permitida [$ext]. \n";
                } 
              }

              //echo $msgfile;

              $objDBO = new DBConfig();
              $objDBO->config();
              $objDBO->conexion();


              $ejecucion = $objDBO->Operaciones("INSERT INTO info_secretaria(nombrec, ciudad, direccion, telefono, usuario, contresena, foto)
                                                                values('$nombresec', '$ciudad', '$direccion', '$telefono', '$email', '$contrasena', '$fotop') ");

if($ejecucion){ // Todo se ejecuto correctamente
    echo "
    <audio controls='' autoplay='' id='ocultar'>
    <source src='../Audios/sony1.mp3' type='audio/mp3'>
    </audio>
    <div class='alert alert-success'>
             su registro correcto
          </div>
          ";
  }else{ // Algo paso mal
    echo "
    <audio controls='' autoplay='' id='ocultar'>
    <source src='../Audios/sony2.mp3' type='audio/mp3'>
    </audio>

    <div class='alert alert-danger'>
             Ha ocurrido un error inexperado
          </div>";
  }

      $objDBO->close();

            }
            ?>


                            <form role="form" name="frm_prods" id="frm_prods" method="POST" action="secretaria_crear.php"
                                enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="txt_nombresec">Nombre de secretaria</label>
                                                <input type="text" class="form-control" id="txt_nombresec" name="txt_nombresec"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <!-- Control Inputbox ejemplo -->
                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="txt_email">correo</label>
                                                <input type="text" class="form-control" id="txt_email" name="txt_email"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="txt_ciudad">Ciudad</label>
                                                <input type="text" class="form-control" id="txt_ciudad" name="txt_ciudad"
                                                    placeholder=""></input>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="txt_dirrecion">Dirreción</label>
                                                <input type="text" class="form-control" id="txt_dirrecion" name="txt_dirrecion"
                                                    placeholder=""></input>
                                            </div>
                                        </div>

                                        <!-- Control VALOR -->
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="txt_telefono">telefono</label>
                                                <input type="text" class="form-control" id="txt_telefono" name="txt_telefono"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <!-- Control cantidad  -->
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="txt_contrasena">contraseña</label>
                                                <input type="contrasena" class="form-control" id="txt_contrasena" name="txt_contrasena"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <!-- Control FileUpload ejemplo -->
                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="txtFile">Subir Foto</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="txt_File"
                                                            name="txt_File">
                                                        <label class="custom-file-label"
                                                            for="txt_File">Seleccionar</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- /.fin row -->

                                </div> <!-- /.fin card-body -->

                                <div class="card-footer">
                                    <button type="submit" id="btn_regist" class="btn bg-primary">Registrarse
                                    </button>
                                    <button type="reset" class="btn btn-default">Limpiar</button>
                                    <a href="productos.php">Volver a la compra</a>
                                </div>

                            </form> <!-- /.fin Form -->

                        </div>

                    </div>
                   <!-- este div es para centrar el formulario -->
                    <div class="col-md-2">

                    </div>
                    <!--  <div class="col-md-6">
                        <img src="../imgs/crear_productos/presentación.jpg">

                    </div>   -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <?php 
      include "includes2/footer.php";
     ?>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="../templates/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../templates/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../templates/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../templates/AdminLTE-3.0.5/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <!-- AdminLTE App -->
    <script src="../templates/AdminLTE-3.0.5/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../templates/AdminLTE-3.0.5/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../templates/AdminLTE-3.0.5/dist/js/demo.js"></script>
</body>

</html>
