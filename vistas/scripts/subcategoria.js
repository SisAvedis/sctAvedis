var tabla;

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
        "../ajax/subcategoria.php?op=selectCategoria",
        function(data)
        {        
            console.log(data);
            $("#idcategoria").html(data);
            $("#idcategoria").selectpicker('refresh');
        }
    );
}

//funcion limpiar
function limpiar()
{
    $("#idsubcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
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
                    url: '../ajax/subcategoria.php?op=listar',
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
        url: "../ajax/subcategoria.php?op=guardaryeditar",
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

function mostrar(idsubcategoria)
{
    $.post(
        "../ajax/subcategoria.php?op=mostrar",
        {idsubcategoria:idsubcategoria},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.nombre);
            $("#descripcion").val(data.descripcion);
            $("#idsubcategoria").val(data.idsubcategoria);
			$("#idcategoria").val(data.idcategoria);
            $("#idcategoria").selectpicker('refresh');

        }
    );
}

//funcion para descativar categorias
function desactivar(idsubcategoria)
{
    bootbox.confirm("¿Estás seguro de desactivar la Subcategoria?",function(result){
        if(result)
        {
            $.post(
                "../ajax/subcategoria.php?op=desactivar",
                {idsubcategoria:idsubcategoria},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function activar(idcategoria)
{
    bootbox.confirm("¿Estás seguro de activar la Subcategoria?",function(result){
        if(result)
        {
            $.post(
                "../ajax/categoria.php?op=activar",
                {idsubcategoria:idsubcategoria},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

init();