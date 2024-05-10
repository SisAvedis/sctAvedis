<?php
    //Activacion de almacenamiento en buffer
    ob_start();
    //iniciamos las variables de session
    session_start();
  
    if(!isset($_COOKIE["nombre"]))
    {
      header("Location: login.html");
    }
  
    else  //Agrega toda la vista
    {
      require 'header.php';

      if($_SESSION['ventas'] == 1)
      {
?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Rodado <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Marca</th>
							<th>Modelo</th>
                            <th>Dominio</th>
                            <th>Tipo</th>
							<th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Marca</th>
							<th>Modelo</th>
                            <th>Dominio</th>
                            <th>Tipo</th>
							<th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Marca:</label>
                            <input type="hidden" name="idrodado" id="idrodado">
                            <input type="text" class="form-control" name="marca" id="marca" maxlength="100" placeholder="Marca" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Modelo:</label>
                            <input type="text" class="form-control" name="modelo" id="modelo" maxlength="100" placeholder="Modelo">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Tipo:</label>
                              <select name="idtipo_rodado" id="idtipo_rodado" data-live-search="true" class="form-control selectpicker" required></select>
						  </div>
						  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dominio:</label>
                            <input type="text" class="form-control" name="dominio" id="dominio" maxlength="7" placeholder="Dominio">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero Chasis:</label>
                            <input type="text"  class="form-control" name="chasis" id="chasis" maxlength="20" placeholder="Chasis">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero Motor:</label>
                            <input type="text"  class="form-control" name="motor" id="motor" maxlength="20" placeholder="Motor">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php

  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>

<script src="./scripts/rodado.js"></script>


<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>