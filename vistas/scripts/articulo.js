var tabla;
var idcategoria;
//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })

    //Cargamos los items al select categoria
    $.post(
        "../ajax/articulo.php?op=selectCategoria",
        function(data)
        {        
            //console.log('Van las categorias...');
			//console.log(data);
            $("#idcategoria").html(data);
			$("#idcategoria").selectpicker('refresh');
			$("#idcategoria").prop('selectedIndex', 0);
			idcategoria = $('select[name=idcategoria] option').filter(':selected').val();
			//console.log('idcategoria (método change idcategoria) al regresar del post -> '+idcategoria);
        }
    );
	
	
	$.post(
        "../ajax/articulo.php?op=selectUnidad",
        function(data)
        {        
            //console.log(data);
            $("#idunidad").html(data);
            $("#idunidad").selectpicker('refresh');
        }
    );
	
    $("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#cantidad").val("");
    $("#idcategoria").val("");
    $("#idcategoria").selectpicker('refresh');
    $("#idsubcategoria").val("");
    $("#idsubcategoria").selectpicker('refresh');
    $("#idunidad").val("1");
    $("#idunidad").selectpicker('refresh');
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");

    $("#print").hide();

    $("#idarticulo").val("");

}

//funcion mostrar formulario
function mostrarform(flag)
{
    limpiar();

    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
		//obtenersubcategorias(idcategoria);
	}
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}



//Funcion listar
function listar()
{
    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/articulo.php?op=listar',
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

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function(error)
        {
            console.log("error: " + error);
        } 
    });

    limpiar();
}

function mostrar(idarticulo,idcategoria2)
{
    
	obtenersubcategorias(idcategoria2);
	idcategoria = idcategoria2;
	
	$.post(
        "../ajax/articulo.php?op=mostrar",
        {idarticulo:idarticulo},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#idcategoria").val(data.idcategoria);
            $('#idcategoria').selectpicker('refresh');
			
					
			$("#idsubcategoria").val(data.idsubcategoria);
            $("#idsubcategoria").selectpicker('refresh');

            $("#idunidad").val(data.idunidad);
            $('#idunidad').selectpicker('refresh');
			
			$("#codigo").val(data.codigo);
            $("#nombre").val(data.nombre);
            $("#cantidad").val(data.stock);
            $("#descripcion").val(data.descripcion);

            $("#imagenmuestra").show(); 
            $("#imagenmuestra").attr("src","../files/articulos/"+data.imagen); //agregamos el atributo src para mostrar la imagen

            $("#imagenactual").val(data.imagen);

            $("#idarticulo").val(data.idarticulo);

            generarbarcode();

        }
    );
	
	
}


//funcion para descativar articulo
function desactivar(idarticulo)
{
    bootbox.confirm("¿Estás seguro de desactivar el Articulo?",function(result){
        if(result)
        {
            $.post(
                "../ajax/articulo.php?op=desactivar",
                {idarticulo:idarticulo},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function activar(idarticulo)
{
    bootbox.confirm("¿Estás seguro de activar el Articulo?",function(result){
        if(result)
        {
            $.post(
                "../ajax/articulo.php?op=activar",
                {idarticulo:idarticulo},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function generarbarcode()
{
    var codigo = $("#codigo").val();
    if (codigo !== ''){
		JsBarcode("#barcode",codigo);
		$("#print").show();
	}
}

function imprimir()
{
    $("#print").printArea();
}

function obtenersubcategorias(idcategoria)
{
	//Cargamos los items al select Subcategoria
	$.post(
		"../ajax/subcategoria.php?op=selectSubCategorias",
		{idcategoria:idcategoria},
		function (data) 
		{
			$("#idsubcategoria").html(data);
			$('#idsubcategoria').selectpicker('refresh');
		}
	)
}

init();

$('#idcategoria').on('change', function() {
	idcategoria = $(this).val();
	
	//Cargamos los items al select subcategoria
	$.post(
		"../ajax/subcategoria.php?op=selectSubCategorias",
		{idcategoria:idcategoria},
		function (r) 
		{
			$("#idsubcategoria").html(r);
			$('#idsubcategoria').prop('selectedIndex', 0);
			idsubcategoria = $('select[name=idsubcategoria] option').filter(':selected').val();
			$('#idsubcategoria').selectpicker('refresh');
		}
	)
	
});

$('#idarticulo').on('change', function() {
	idarticulo = $(this).val();
});