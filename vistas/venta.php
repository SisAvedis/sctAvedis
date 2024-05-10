<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_COOKIE["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['ventas']==1)
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
                          <h1 class="box-title">Entrega Operarios<button class="btn btn-success"  style="margin-left: 20px" id="btnagregar" onclick="mostrarform(true,true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Operario</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <!--<th>Total Venta</th>-->
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Operario</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <!--<th>Total Venta</th>-->
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
		
					<div class="panel-body" style="height: auto;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Operario(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <select title="<b>Seleccione un Operario</b>" id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required>
                              
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option value="Orden de Salida">Orden Salida</option>
                               <!--<option value="Extravio">Extravio</option>-->
                               <!--<option value="Ticket">Ticket</option>-->
                            </select>
                          </div>
						  
						  <div class="panel-body" id="listadocabecera">
							<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<label>Serie:</label>
								<input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
							</div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
								<label>Numero:</label>
								<input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero">
							</div>
						  </div>

						  <!--
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto" required="">
                          </div>
						  -->
                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-14">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observacion" id="observacion" maxlength="10000" placeholder="Observaciones">
                          </div>
						  
						  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary" onclick="consultarDetalle()"> 
								<span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>
                          </div>
						  
						  
						  
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
							                  		<th>Codigo</th>
                                    <th>Artículo</th>
                                  <th>Descripcion</th>
                                  <th>Categoría</th>
                                <th>SubCategoria</th>
                                  <th>Cantidad</th>
                                  <th>Ubicación Origen</th>
                                    <th>Ubicación Destino</th>
                                    <!--<th>Subtotal</th>-->
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
									                  <th></th>
									                  <th></th>
									                  <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <!--<th><h4 id="total">$ 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> -->
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="limpiar();cancelarform();" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!-- ***************************MODAL ARTICULOS**************************** -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 90% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
				<th>Descripcion</th>
                <th>Categoría</th>
				        <th>SubCategoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripcion</th>
				<th>Categoría</th>
				<th>SubCategoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->
  <!-- ******************************MODAL DEPOSITOS*************************-->
  <div class="modal fade" id="deposiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cierreModalDepositos()">&times;</button>
          <h4 class="modal-title" >
            <b id="artiSeleccion"></b>
            <br/>
            Ubicaciones a Depositar  
          
                          </h4>
        </div>
        <div class="modal-body">
          <table id="tbldepositos" class="table table-striped table-bordered table-condensed table-hover">
           
          <thead>
                <th style="width: 30px">Opciones</th>
                <th>Nombre</th>
				        <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Ubicacion Origen</th>
                
               
				
            </thead>
            
            <tbody>
             
            
             
            </tbody>
            <!--<tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripcion</th>
				        <th>Cantidad</th>
                <th>Ubicacion Origen</th>
                
				
            </tfoot>-->
          </table>
        </div>
        <div class="modal-footer">
        
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cierreModalDepositos()">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal Depositos-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<!--JQUERY VALIDATE -->
<script  src="../public/js/jquery-validate/dist/jquery.validate.js"></script>
<script type="text/javascript" src="scripts/venta.js"></script>

<script>
$('#deposiModal').on("hidden.bs.modal", function(e) {
	$("#filaCabecera").detach();
	$("#artiSeleccion").empty();
  $("#tbldepositos").empty();
  //$( "#tbldepositos" ).load( "solicitudesdeextraccion.php #tbldepositos" );
});

//$( "#tbldepositos" ).load( "venta.php #tbldepositos" );

   $(document).ready(function() {
    
    $("#formulario").on("keypress", function (event) {
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                event.preventDefault();
                return false;
            }
        });

  $("#formulario").validate({
    focusCleanup: true,
    ignore: [],
    rules: {
    'cantidad[]':{required:true},
    idoperario : {
      required: true,
      minlength: 1,
    },
  fecha_hora: {
    required: true,
    minlength: 3,
    },},
   
errorClass: "invalid"

  });
})
  $("#btnGuardar").click( function(e) {
	
  $("#formulario").target = '_blank';
  //e.preventDefault();
  console.log($("#formulario"));
  if ($('#formulario').valid()) {
  $("#formulario").submit();
  $("#formulario").validate().resetForm();
  }
})

jQuery.extend(jQuery.validator.messages,{
		required: "Este campo es obligatorio.",
		remote: "Please fix this field.",
		email: "Please enter a valid email address.",
		url: "Please enter a valid URL.",
		date: "Ingrese una fecha válida.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Ingrese un numero válido.",
		digits: "Please enter only digits.",
		equalTo: "Please enter the same value again.",
		maxlength: $.validator.format( "Ingrese no mas de {0} caracteres." ),
		minlength: $.validator.format( "Ingrese al menos {0} caracteres." ),
		rangelength: $.validator.format( "Please enter a value between {0} and {1} characters long." ),
		range: $.validator.format( "Ingrese un valor entre {0} y {1}." ),
		max: $.validator.format( "Ingrese un valor menor o igual a {0}." ),
		min: $.validator.format( "Ingrese un valor mayor o igual a {0}." ),
		step: $.validator.format( "Please enter a multiple of {0}." )
	},);

  $('.modal').css('overflow-y', 'auto');
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<?php 
}
ob_end_flush();
?>


