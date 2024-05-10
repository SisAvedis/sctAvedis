<?php
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 
  if(isset($_COOKIE['sistema']))
  if($_COOKIE['sistema'] != '1'){
    session_unset(); //Limpiamos las variables de sesion
    session_destroy(); //Destriumos la sesion
    if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie) {
          $parts = explode('=', $cookie);
          $name = trim($parts[0]);
          setcookie($name, '', time()-1000);
          setcookie($name, '', time()-1000, '/');
      }
  }
    header("Location: login.html");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SCT | Taller</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/avedis_favicon.ico">

    <!--DATATABLES-->
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
    
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
    

  </head>
  <body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SCT</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Talleres</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_COOKIE['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_COOKIE['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_COOKIE['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      Sistemas
                      <small>Avedis</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php
              if($_SESSION['escritorio'] == 1)
              {
                echo 
                '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Escritorio</span>
                  </a>
                </li>';
              }

              if($_SESSION['almacen'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Depósito</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="movimiento.php"><i class="fa fa-circle-o"></i> Movimientos</a></li>
					  <li><a href="ubicacion.php"><i class="fa fa-circle-o"></i> Ubicaciones</a></li>
                    </ul>
                  </li>'
                 ;
              }
			  if($_SESSION['articulo'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Artículo</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                      <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
					  <li><a href="subcategoria.php"><i class="fa fa-circle-o"></i> SubCategorías</a></li>
					  <li><a href="unidad.php"><i class="fa fa-circle-o"></i> Unidades de Medida</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['compras'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i>
                      <span>Ingresos</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Entradas</a></li>
					  <!--<li><a href="devolucionp.php"><i class="fa fa-circle-o"></i> Devoluciones</a></li>-->
					  <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['ventas'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Egresos Operarios</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="venta.php"><i class="fa fa-circle-o"></i> Salidas</a></li>
					  <li><a href="devolucion.php"><i class="fa fa-circle-o"></i> Devoluciones</a></li>
                      <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Operarios</a></li>
					  <li><a href="sector.php"><i class="fa fa-circle-o"></i> Sectores</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Egresos Rodados</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventarodado.php"><i class="fa fa-circle-o"></i> Salidas</a></li>
					  <li><a href="devolucionrodado.php"><i class="fa fa-circle-o"></i> Devoluciones</a></li>
                      <li><a href="rodado.php"><i class="fa fa-circle-o"></i> Rodados</a></li>
					  <li><a href="tiporodado.php"><i class="fa fa-circle-o"></i> Tipo Rodado</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['acceso'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-folder"></i> <span>Acceso</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                      <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                      
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['consultac'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Ingresos</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Ingresos</a></li>                
                    </ul>
                  </li>'
                 ;
              }

              if($_SESSION['consultav'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Egresos</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Ordenes por Fecha y Operario</a></li>
                    <li><a href="ventassolofechacliente.php"><i class="fa fa-circle-o"></i> Ordenes Operarios por Fecha </a></li>
                      <li><a href="ventasfecharodado.php"><i class="fa fa-circle-o"></i> Ordenes por Fecha y Rodado</a></li>
                      <li><a href="ventassolofecharodado.php"><i class="fa fa-circle-o"></i> Ordenes Rodados por Fecha </a></li>
					  <li><a href="entregasfechaoperario.php"><i class="fa fa-circle-o"></i> Articulos (E) Fecha Operario</a></li>
					  <li><a href="entregasfechaoperariocategoria.php"><i class="fa fa-circle-o"></i> Articulos(E) Fecha Operario (Cat)</a></li>
					  <li><a href="entregasfechasectorcategoria.php"><i class="fa fa-circle-o"></i> Articulos(E) Fecha Sector (Cat)</a></li>
					  <li><a href="entregasfechaoperarioagrupado.php"><i class="fa fa-circle-o"></i> Articulos(E) Fecha Operario (Agr)</a></li>
					  <li><a href="devolucionesfechaoperario.php"><i class="fa fa-circle-o"></i> Articulos (D) Fecha Operario</a></li>
					  <li><a href="devolucionesfechaoperarioagrupado.php"><i class="fa fa-circle-o"></i> Articulos(D) Fecha Operario (Agr)</a></li>	
					</ul>
                  </li>'
                 ;
              }
			 
			  if($_SESSION['consultas'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Stock</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
					  <li><a href="stockproducto.php"><i class="fa fa-circle-o"></i> Stock Articulo</a></li>
					  <li><a href="stockcategoria.php"><i class="fa fa-circle-o"></i> Stock Categoria</a></li>
                      <li><a href="stockubicacion.php"><i class="fa fa-circle-o"></i> Stock Ubicacion</a></li>
					  <li><a href="stockubicacionconfiltro.php"><i class="fa fa-circle-o"></i> Stock Ubicacion CF</a></li>
					  <li><a href="movimientosarticulo.php"><i class="fa fa-circle-o"></i> Movimientos Articulo Ubicacion</a></li>
                    </ul>
                  </li>'
                 ;
              }
            ?>                                
          
            <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>