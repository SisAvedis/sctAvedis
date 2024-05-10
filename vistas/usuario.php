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

      if($_SESSION['acceso'] == 1)
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
                          <h1 class="box-title">Usuarios <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero Doc.</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero Doc.</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select name="tipo_documento" id="tipo_documento" data-live-search="true" class="form-control selectpicker" required>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEDULA">CEEDULA</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero Doc.:</label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Numero Doc." required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Telefono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Telefono">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo:</label>
                            <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Login(*):</label>
                            <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Clave(*):</label>
                            <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Permisos:</label>
                            <ul style="list-style:none;" id="permisos">
                            </ul>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

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
<script src="./scripts/usuario.js"></script>

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
<script  src="../public/js/jquery-validate/dist/jquery.validate.js"></script>

<style>
  .error{
    color:red;
  }
</style>
<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>