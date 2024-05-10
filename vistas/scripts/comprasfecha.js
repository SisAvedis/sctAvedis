var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    listar();
    $("#fecha_inicio").change(listar);
    $("#fecha_fin").change(listar);


}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();

    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
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
                "ajax":{
                    url: '../ajax/consultas.php?op=comprasfecha',
                    data:{fecha_inicio:fecha_inicio, fecha_fin:fecha_fin},
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