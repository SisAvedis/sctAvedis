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

    if($_SESSION['consultas'] == 1)
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
                        <h1 class="box-title">Consulta de Stock por Artículo</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="">Categoria</label>
                            <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
						<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="">Artículo</label>
                            <select name="idarticulo" id="idarticulo" class="form-control selectpicker" data-live-search="true" required></select>
                            <button class="btn btn-success" onclick="listar()">Mostrar</button>
                        </div>
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Codigo</th>
                            <th>Articulo</th>
							<th>Descripcion</th>
							<th>Cantidad</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Codigo</th>
                            <th>Articulo</th>
							<th>Descripcion</th>
                            <th>Cantidad</th>
                          </tfoot>
                        </table>
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

<script src="./scripts/stockproducto.js"></script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>