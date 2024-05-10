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

    if($_SESSION['compras'] == 1)
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
                          <h1 class="box-title">Ingreso <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero Doc.</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero Doc.</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Proveedor(*):</label>
                            <input type="hidden" name="idingreso" id="idcategoria">
                            <select title="<b>Seleccione un Proveedor</b>" name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                             <label>Observación:</label>
                            <input type="text" class="form-control" name="observacion" id="observacion" >
                            
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select title="<b>Seleccione un Comprobante</b>" class="form-control selectpicker" name="tipo_comprobante" id="tipo_comprobante" required>
                              <option value="Remito">Remito</option>
                              <option value="Factura">Factura</option>
                              <option value="Ticket">Ticket</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Numero:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a data-toggle="modal" href="#myModal" >
                                <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                  <span class="fa fa-plus"></span>
                                  Agregar Articulos
                                </button>
                              </a>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5">
                                  <th>Opciones</th>
								  <th>Codigo</th>
                                  <th>Articulo</th>
								  <th>Descripcion</th>
								  <th>Categoria</th>
								  <th>SubCategoria</th>
                                  <th>Cantidad</th>
                                  <th>Precio Compra</th>
                                  <th>Subtotal</th>
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
                                  <th>
                                    <h4 id="total">$ 0.00</h4>
                                    <input type="hidden" name="total_compra" id="total_compra">
                                  </th>
                                </tfoot>
                                <tbody>

                                </tbody>
                              </table>
                          </div>
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!--VENTANA MODAL-->
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog" style="width: 65% !important;"> <!--Agregado para poder agregar más campos al datatable -->
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title">Seleccione un articulo</h4>
           </div>

           <div class="modal-body">
             <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
               <thead>
                 <th>Opciones</th>
                 <th>Nombre</th>
				 <th>Descripcion</th>
                 <th>Categoria</th>
				 <th>SubCategoria</th>
                 <th>Codigo</th>
                 <th>Stock</th>
                 <th>Imagen</th>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                 <th>Opciones</th>
                 <th>Nombre</th>
				 <th>Descripcion</th>
                 <th>Categoria</th>
				 <th>SubCategoria</th>
                 <th>Codigo</th>
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
  <!--FIN VENTANA MODAL-->


<?php
  
  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>
<!-- jQuery Validate 1.19.5 -->
<script  src="../public/js/jquery-validate/dist/jquery.validate.js"></script>
<script src="./scripts/ingreso.js"></script>
<script>
   $(document).ready(function() {
    
    $("#formulario").on("keypress", function (event) {
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                event.preventDefault();
                return false;
            }
        });

  $("#formulario").validate({
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
    /*checkForm: function() {
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
        if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
            }
        } else {
            this.check(elements[i]);
        }
    }
    return this.valid();
},*/
errorClass: "errors",
highlight: function (element) {
                $(element).parent().addClass('error')
            },
  unhighlight: function (element) {
  $(element).parent().removeClass('error')
  }

  });
})
  $("#btnGuardar").click( function(e) {
	
  $("#formulario").target = '_blank';
  //e.preventDefault();
  console.log($("#formulario"));
  if ($('#formulario').valid()) {
  $("#formulario").submit();
 /* $("#formulario").on("submit",function(e)
{
  //e.preventDefault();
  guardaryeditar(e);	
  limpiar();
  /*bootbox.alert({
			  message : "Solicitud creada con éxito",
			  timeOut : 5000
			  });
});*/
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
<style>
  .error{
    color:red;
  }
</style>


<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>