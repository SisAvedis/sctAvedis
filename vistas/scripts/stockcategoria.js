var tabla;
var idcategoria = 1;

//Funcion que se ejecuta al inicio
function init()
{
 	//listar();
	//Cargamos los items al select categoria
   $.post("../ajax/articulo.php?op=selectCategoria", function (r) {
        $("#idcategoria").html(r);
		$('#idcategoria').val(idcategoria);
        $('#idcategoria').selectpicker('refresh');
   });
	
}

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
                    url: '../ajax/consultas.php?op=stockcategoria',
                    data:{idcategoria:idcategoria},
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
$('#idcategoria').on('change', function() {
	idcategoria = $(this).val();
});



