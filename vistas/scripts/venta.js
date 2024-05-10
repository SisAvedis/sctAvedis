var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false,false);
	evaluar();
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
		limpiar();
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');
	});	
	
		
}

//FUNCION VALIDACION CANTIDADES
function minMaxValidationFunc(that, value){
	let min = parseInt(that.getAttribute("min"));
	let max = parseInt(that.getAttribute("max"));
	let val = parseInt(value);

	if(val<min||isNaN(val)){
		return min;
	}
	else if (val> max){
		return max;
	}
	else {
		return val;
	}
}

//Función limpiar
function limpiar()
{
	$("#idventa").val("");
	$("#idoperario").val("");
	$("#idoperario").selectpicker('refresh');
	$("#idcliente").selectpicker('refresh');
	$("#operario").val("");
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");
	$("#observacion").val("");
	
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val("");

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag1,flag2)
{
	//FUNCION LIMPIAR BUSCADOR DATATABLE
	var allDataTables = $('.dataTable').DataTable();
	allDataTables.state.clear();
	//limpiar();
	if(flag1 && flag2)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#listadocabecera").hide();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnguardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
	}

	else if(!flag1 && flag2)
    {
        $("#listadoregistros").hide();
		$("#listadocabecera").show();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
		
    }

	else if(!flag1 && !flag2)
    {
        $("#listadoregistros").show();
		$("#listadocabecera").hide();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }

/*
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
*/
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	location.reload();
	mostrarform(false,false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
					{
                        extend: 'excelHtml5',
                        title: function(){
                            var nombreExcel;
                            nombreExcel = prompt("Ingresar nombre del Excel");
                            return nombreExcel;
                        }
                    },
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función ListarArticulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarArticulos',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				stateSave:true,
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

function listarArticulosUno(idartubi)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/venta.php?op=listarArticulosUno',
                    data: {idartubi:idartubi},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}


//Función para guardar o editar

function guardaryeditar(e)
{
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	// Display the key/value pairs
	for (var pair of formData.entries()) {
		console.log(pair[0]+ ', ' + pair[1]); 
	}
	
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
	    type: "POST",
		async:false,
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);
			  	          
	          mostrarform(false,false);
	          listar();
			  //location.reload();
	    },
		error:function(error){
			console.log(error);
		}

	});
	limpiar();
}

function mostrar(idventa)
{
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(false,true);

		$("#idcliente").val(data.idcliente);
		$("#idcliente").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idventa").val(data.idventa);
		$("#observacion").val(data.comentario);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detalles").html(r);
	});	
}

//Función para anular registros
function anular(idventa)
{
	bootbox.confirm("¿Está seguro de anular la entrega?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }

function agregarDetalle(idarticulo,idubi_origen,articulo,descripcion,categoria,subcategoria,codigo,codigo_origen,cantidad)
{
    //var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 3;
	var idubi_destino = 1;
	var codigo_destino = "EXT";
	console.log('Valor de cantidad -> '+cantidad);
	if(idarticulo != "")
    {
        //var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                      '<td>'+
                           '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="codigo[]" value="'+codigo+'">'+
                           codigo +
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+
                           articulo +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="descripcion[]" value="'+descripcion+'">'+
						  descripcion +
                       '</td>'+
					  '<td>' +
                          '<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
						  //'<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idubi_origen[]" value="'+idubi_origen+'">'+codigo_origen+
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="idubi_destino[]" value="'+idubi_destino+'">'+codigo_destino+
                       '</td>'+ 
                   '</tr>';

        cont++;
        detalles++;
        $("#detalles").append(fila);
        //modificarSubtotales(); 
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del articulo");
    }
	
	evaluar();
	
	consultarDetalle();

}

function agregarArticuloADeposito(idarticulo,idubi_origen,articulo,descripcion,categoria,subcategoria,codigo,codigo_origen,cantidad)
{
    //var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 3;
	var idubi_destino = 1;
	var codigo_destino = "EXT";

	if(idarticulo != "")
    {
        //var subtotal = cantidad * precio_compra;
        var fila = 
						'<tr id="filaCabecera" style="display:none">'+
						'<td>'+
						'<input type="hidden" id="codigo" value="'+codigo+'">'+
						codigo +
					'</td>'+
				   '<td>' +
					   '<input type="hidden" id="idarticulo" value="'+idarticulo+'">'+
						articulo +
					'</td>'+
				   '<td>' +
					   '<input type="hidden" id="descripcion" value="'+descripcion+'">'+
					   descripcion +
					'</td>'+
					'<td>' +
					'<input type="number" step="0.01"  min="0" max="'+cantidad+'" id="cantidad" value="'+cantidad+'">'+
					'<input type="hidden" id="codigo_origen" value="'+codigo_origen+'">'+
					'<input type="hidden" id="categoria" value="'+categoria+'">'+
					'<input type="hidden" id="subcategoria" value="'+subcategoria+'">'+
					'<input type="hidden" id="idubi_origen" value="'+idubi_origen+'">'+
					'</td>'+
				   '<td style="display:none">' +
					'</td>'+
					   +'</tr>'
					 
                      
                   ;

        cont++;
        detalles++;
		
        $("#tbldepositos thead").append(fila);
		$("#artiSeleccion").append(articulo);
        //modificarSubtotales(); 
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del articulo");
    }
	
	evaluar();
	
	//consultarDetalle();

}

function agregarPedido(idarticulo, idubicacion, c_ubi, cantidad, cantFilas)
{

    //var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 3;
	
	var articulo = $("#artiSeleccion").text();
	//var idarticulo = $("#idarticulo").val();
	var descripcion = $("#descripcion").val();
	var idubi_origen = idubicacion;
	var codigo_origen = c_ubi;
	var idubi_destino = 1;
	var codigo_destino = "EXT";
	var categoria = $("#categoria").val();
	var subcategoria = $("#subcategoria").val();
	//var cantidad = $("#cantidad").val();
	console.log("Id Articulo:"+ idarticulo, "\nArticulo:"+ articulo,"\nDescripcion:"+ descripcion, "\nCategoria:"+ categoria, "\nSubcategoria:"+subcategoria,"\nId Ubicacion Origen:"+ idubi_origen, "\nCodigo de Origen:"+ codigo_origen, "\nCantidad:"+ cantidad, "\nCantidad Filas:"+ cantFilas);

	if(idarticulo != "")
    {
        //var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                      '<td>'+
                           '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="codigo[]" value="'+idarticulo+'">'+
                           idarticulo +
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+
                           articulo +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="descripcion[]" value="'+descripcion+'">'+
						  descripcion +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="categoria[]" value="'+categoria+'">'+
						  categoria +
                       '</td>'+	
                     
					  '<td>' +
                          '<input type="hidden" name="subcategoria[]" value="'+subcategoria+'">'+
						  subcategoria +
                       '</td>'+	
					   
                      '<td>' +
					  '<button type="button" onmousedown="this.nextElementSibling.stepDown(); " class="btn-xs btn-primary" ><i class="fa fa-minus"></i></button>'+
                          '<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" onkeyup="this.value = minMaxValidationFunc(this, this.value)" id="cantidad[]" value="'+cantidad+'" style="max-width: 55px" required>'+
						  '<button type="button" onmousedown="this.previousElementSibling.stepUp(); " class="btn-xs btn-primary"><i class="fa fa-plus"></i></button>'+
						  '</td>'+
                     
					  '<td>' +
                          '<input type="hidden" name="idubi_origen[]" value="'+idubi_origen+'">'+codigo_origen+
                       '</td>'+ 
					   '<td>' +
					   '<input type="hidden" name="idubi_destino[]" value="'+idubi_destino+'">'+codigo_destino+
						   
					'</td>'+
                   '</tr>';

        cont++;
        detalles++;
        $("#detalles").append(fila);
        //modificarSubtotales(); 
		$.post("../ajax/ubicacion.php?op=select", function(r){
			$(".idUbi.selectpicker").html(r);
			$('.idUbi.selectpicker').selectpicker('refresh');
});	
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del articulo");
    }
	
	
	
	evaluar();
	
	consultarDetalle();
	if(cantFilas > 1){
		
	consultarDetalleSegundoModal(idarticulo);
	}
	else if(cantFilas == 1){
		$('#deposiModal').modal("toggle");
		$('.modal-backdrop.fade.in').remove();
	}
	else{		
		//RefreshTable();
		cierreModalDepositos();
		$('#deposiModal').modal("toggle");
		$('.modal-backdrop.fade.in').remove();
		$('.modal-backdrop.fade.in').toggle('hide');
		}

}

function agregarDeposito(idubicacion,codigo,descripcion,cantidad)
{
    //var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 3;
	var idubi_destino = 1;
	var codigo_destino = "EXT";

	if(idubicacion != "")
    {
        //var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                      '<td>'+
                           '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                       '</td>'+
					  
                      '<td>' +
                          '<input type="hidden" name="idarticulo[]" value="'+idubicacion+'">'+
                           codigo +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="descripcion[]" value="'+descripcion+'">'+
						  descripcion +
                       '</td>'+
					              
					  
                      '<td>' +
                          '<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
                       '</td>'
                     
                   '</tr>';

        cont++;
        detalles++;
        $("#tbldepositos").append(fila);
		
        //modificarSubtotales(); 
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del articulo");
    }
	
	evaluar();
	
	//consultarDetalle();

}

function detalleUbicacion(idarticulo,idubi_origen,articulo,descripcion,categoria,subcategoria,codigo,codigo_origen,cantidad)
{
    //var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 3;
	var idubi_destino = 1;
	var codigo_destino = "EXT";

	if(idarticulo != "")
    {
        //var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                      '<td>'+
                           '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="codigo[]" value="'+codigo+'">'+
                           codigo +
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+
                           articulo +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="descripcion[]" value="'+descripcion+'">'+
						  descripcion +
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="categoria[]" value="'+categoria+'">'+
						  categoria +
                       '</td>'+	
                     
					  '<td>' +
                          '<input type="hidden" name="subcategoria[]" value="'+subcategoria+'">'+
						  subcategoria +
                       '</td>'+	
                      '<td>' +
                          '<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idubi_origen[]" value="'+idubi_origen+'">'+codigo_origen+
                       '</td>'+
					  '<td>' +
                          '<input type="hidden" name="idubi_destino[]" value="'+idubi_destino+'">'+codigo_destino+
                       '</td>'+ 
                   '</tr>';

        cont++;
        detalles++;
        $("#detalles").append(fila);
        //modificarSubtotales(); 
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del articulo");
    }
	
	evaluar();
	
	//consultarDetalle();

}

function listarArticulosId(idarticulo)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tbldepositos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/venta.php?op=listarArticulosId',
                    data: {idarticulo:idarticulo},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
				stateSave:true,
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
			consultarDetalleSegundoModal(idarticulo);
			$('#tbldepositos').DataTable();

		
}

function controlIdUno(idarticulo){
	
	listarArticulosId(idarticulo);
	console.log($("#tblarticulos_filter"));
	
	
}

function listarArticulosIdUno(idartubi, idarticulo)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tbldepositos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/venta.php?op=listarArticulosIdUno',
                    data: {idartubi:idartubi, idarticulo:idarticulo},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}

function listarUbicacionesUno(idubi)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tblubicaciones')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/solicitudesdeextraccion.php?op=listarUbicacionesUno',
                    data: {idubi:idubi},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}

function listarUbicacionesCodigo(idubi)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tblubicaciones')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/solicitudesdeextraccion.php?op=listarUbicacionesCodigo',
                    data: {idubi:idubi},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}

function consultarDetalle()
{	
	var idart = document.getElementsByName("idarticulo[]");
	var idubi = document.getElementsByName("idubi_origen[]");
	var canti = document.getElementsByName("cantidad[]");
	var tamañoCant = idart.length;
	console.log('Valor de tamañoCant -> '+tamañoCant);
	var idartubi = '';
	for (var i=0;i<tamañoCant;i++){
	idartubi += idubi[i].value+','+idart[i].value+','+canti[i].value+',';
	}
	console.log('Valor de idartubi -> '+idartubi);
	if (tamañoCant !== 0){  
		listarArticulosUno(idartubi);
	}else{
		listarArticulos();
	}

}

function consultarDetalleSegundoModal(idarticulo)
{	
	var articuloActual = idarticulo;
	var idart = document.getElementsByName("idarticulo[]");
	var idubi = document.getElementsByName("idubi_origen[]");
	var canti = document.getElementsByName("cantidad[]");
	var tamañoCant = idart.length;
	//console.log('Valor de tamañoCant -> '+tamañoCant);
	var idartubi = '';
	for (var i=0;i<tamañoCant;i++){
	
	
		idartubi += idubi[i].value+','+idart[i].value+','+canti[i].value+',';
		console.log( idubi[i].value+','+idart[i].value+','+canti[i].value+',')
	}

	
	console.log('Valor de idartubi -> '+idartubi);
	console.log("Articulo Actual:"+articuloActual)
	if (tamañoCant > 0 ){ 
	
		listarArticulosIdUno(idartubi, articuloActual);
		cierreModalArticulos();
		
		
		}
		else{
			
		}
	
}

//FUNCION QUE MUESTRA MODAL UBICACIONES

function consultarUbicaciones()
{	
	$("").show();
	var idubi = document.getElementsByName("idubicacion[]");
	var canti = document.getElementsByName("cantidad[]");
	var tamañoCant = idubi.length;
	//console.log('Valor de tamañoCant -> '+tamañoCant);
	var idartubi = '';
	for (var i=0;i<tamañoCant;i++){
	idartubi += idubi[i].value+','+canti[i].value+',';
	}
	console.log('Valor de idartubi -> '+idartubi);
	if (tamañoCant !== 0){  
		listarUbicaciones(idartubi);
	}else{
		listarUbicaciones();
	}

}

function modificarSubototales()
{
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];

    	inpS.value=(inpC.value * inpP.value)-inpD.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();

}

function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("S/. " + total);
    $("#total_venta").val(total);
    evaluar();
  }

function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
}

function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
}

function RefreshTable() {
	$( "#tbldepositos" ).load( "venta.php #tbldepositos" );
}

function cierreModalArticulos(){
	$('.modal-backdrop.fade.in').remove();
}
function cierreModalDepositos(){
	$("#filaCabecera").detach();
	$("#artiSeleccion").empty();
	$( "#tbldepositos thead" ).remove();
	
	//RefreshTable();

	//calcularTotales();
	//detalles=detalles-1;
	evaluar();
}

init();