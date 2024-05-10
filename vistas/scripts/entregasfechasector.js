var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select cliente
    $.post("../ajax/venta.php?op=selectSector", function (r) {
        $("#idsector").html(r);
        $('#idsector').selectpicker('refresh');
    });
}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var idsector = $("#idsector").val();

	//console.log('Valor de idcategoria -> '+idcategoria);

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
                    url: '../ajax/consultas.php?op=entregasfechasector',
                    data:{fecha_inicio:fecha_inicio, fecha_fin:fecha_fin,idsector:idsector},
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


init();