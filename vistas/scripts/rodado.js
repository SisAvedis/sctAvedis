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
	//Cargamos los items al select TipoRodado
	$.post("../ajax/tiporodado.php?op=selectTipoRodado", function(r){
	            $("#idtipo_rodado").html(r);
	            $('#idtipo_rodado').selectpicker('refresh');
	});	
}

//funcion limpiar
function limpiar()
{
    $("#marca").val("");
    $("#modelo").val("");
    $("#dominio").val("");
    $("#chasis").val("");
    $("#motor").val("");
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
                    url: '../ajax/rodado.php?op=listar',
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
        url: "../ajax/rodado.php?op=guardaryeditar",
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

function mostrar(idrodado)
{
    $.post(
        "../ajax/rodado.php?op=mostrar",
        {idrodado:idrodado},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#marca").val(data.marca);

            $("#idtipo_rodado").val(data.idtipo_rodado);
            $("#idtipo_rodado").selectpicker('refresh');

            $("#modelo").val(data.modelo);
            $("#dominio").val(data.dominio);
            $("#chasis").val(data.chasis);
            $("#motor").val(data.motor);
        }
    );
}

//funcion para desacativar rodado
function desactivar(idrodado)
{
    bootbox.confirm("¿Estás seguro de desactivar el Rodado?",function(result){
        if(result)
        {
            $.post(
                "../ajax/rodado.php?op=desactivar",
                {idrodado:idrodado},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function activar(idrodado)
{
    bootbox.confirm("¿Estás seguro de activar el Rodado?",function(result){
        if(result)
        {
            $.post(
                "../ajax/rodado.php?op=activar",
                {idrodado:idrodado},
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