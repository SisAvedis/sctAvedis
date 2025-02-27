var tabla;
//var idrodado;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false,false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/rodado.php?op=selectRodado", function(r){
		$("#idrodado").html(r);
		//$("#idrodado").val(idrodado);
		$('#idrodado').selectpicker('refresh');
		//$('#idrodado').prop('selectedIndex', 0);
		//console.log('Valor de idrodado -> '+$("#idrodado").val());
});
	
		
}

//Función limpiar
function limpiar()
{
	$("#iddevolucion").val("");
	$("#idrodado").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag1,flag2)
{
	//limpiar();
	if(flag1 && flag2)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#listadocabecera").hide();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		//listarArticulos();

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
	mostrarform(false);
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
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/devolucionrodado.php?op=listar',
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
	$('#idrodado').selectpicker('refresh');
	var idrodado = $("#idrodado").val();
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/devolucionrodado.php?op=listarArticulos',
					data: {idrodado:idrodado},
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
	
	
	console.log('rodado -> '+idrodado); 
	
}

function listarArticulosUno(idartubi,idrodado)
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
                    url: '../ajax/devolucionrodado.php?op=listarArticulosUno',
                    data: {idartubi:idartubi,idrodado:idrodado},
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
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	// Display the key/value pairs
	for (var pair of formData.entries()) {
		console.log(pair[0]+ ', ' + pair[1]); 
	}
	
	$.ajax({
		url: "../ajax/devolucionrodado.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
		async:false,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

function mostrar(iddevolucion)
{
	$.post("../ajax/devolucionrodado.php?op=mostrar",{iddevolucion : iddevolucion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(false,true);

		$("#idrodado").val(data.idrodado);
		$("#idrodado").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#iddevolucion").val(data.iddevolucion);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/devolucionrodado.php?op=listarDetalle&id="+iddevolucion,function(r){
	        $("#detalles").html(r);
	});	
}

//Función para anular registros
function anular(iddevolucion)
{
	bootbox.confirm("¿Estás seguro de anular la devolución?", function(result){
		if(result)
        {
        	$.post("../ajax/devolucionrodado.php?op=anular", {iddevolucion : iddevolucion}, function(e){
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
	//var idubi_destino = 1;
	//var codigo_destino = "EXT";
	
	$.post(
        "../ajax/movimiento.php?op=selectMovDestinoDos",
        function(data)
        {
            for (var i=0;i<cont;i++){
			$("#ubi_des"+i).html(data);
            $("#ubi_des"+i).selectpicker('refresh');
        }
		}
    );

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
                       '</td>'+
                      '<td>' +
                          '<input type="hidden" name="idubi_origen[]" value="'+idubi_origen+'">'+codigo_origen+
                       '</td>'+
					   '<td>' +
						  '<select name="ubi_des[]" id="ubi_des'+cont+'" data-live-search="true" class="form-control selectpicker"></select>'+
                          //'<select name="ubi_des'+cont+'" id="ubi_des'+cont+'" data-live-search="true" class="form-control //selectpicker"></select>'+
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
function consultarDetalle()
{	
	
	var idrodado = $("#idrodado").val();
	$('#idrodado').selectpicker('refresh');
	var idart = document.getElementsByName("idarticulo[]");
	//var idubi = document.getElementsByName("idubi_origen[]");
	var canti = document.getElementsByName("cantidad[]");
	var tamañoCant = idart.length;
	//console.log('Valor de tamañoCant -> '+tamañoCant);
	var idartubi = '';
	for (var i=0;i<tamañoCant;i++){
	//idartubi += idubi[i].value+','+idart[i].value+','+canti[i].value+',';
	idartubi += idart[i].value+','+canti[i].value+',';
	}
	console.log('Valor de idartubi -> '+idartubi);
	console.log('Valor de idrodado -> '+idrodado);
	if (tamañoCant !== 0){  
		listarArticulosUno(idartubi,idrodado);
	}else{
		listarArticulos();
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

init();

/*$('#idrodado').on('focusout', function() {
	console.log("Por hasta...");
	idrodado = $(this).val();
});*/