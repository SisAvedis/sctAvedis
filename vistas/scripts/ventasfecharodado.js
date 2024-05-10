var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select proveedor
    $.post("../ajax/rodado.php?op=selectRodado", function (r) {
        $("#idrodado").html(r);
        $('#idrodado').selectpicker('refresh');
    });	

}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var idrodado = $("#idrodado").val();

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
                    url: '../ajax/consultas.php?op=ventasfecharodado',
                    data:{fecha_inicio:fecha_inicio, fecha_fin:fecha_fin,idrodado:idrodado},
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