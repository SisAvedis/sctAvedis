var tabla;
var idubicacion_desde = 11;
var idubicacion_hasta = 11;
//Funcion que se ejecuta al inicio
function init()
{
    //listar();
	//Cargamos los items al select ubicacion
   $.post("../ajax/ubicacion.php?op=select", 
		function (r) {
			$("#idubicacion_desde").html(r);
			$('#idubicacion_desde').val(idubicacion_desde);
			$('#idubicacion_desde').selectpicker('refresh');
		}
	);
   
   $.post("../ajax/ubicacion.php?op=selecthasta", 
		{idubicacion_desde:idubicacion_desde},
		function (r) {
			$("#idubicacion_hasta").html(r);
			$('#idubicacion_hasta').val(idubicacion_hasta);
			$('#idubicacion_hasta').selectpicker('refresh');
		}
	);
   

}

function listar()
{
    //var fecha_inicio = $("#fecha_inicio").val();
    //var fecha_fin = $("#fecha_fin").val();
	
	//console.log('idubicacion_desde -> '+idubicacion_desde);
	//console.log('idubicacion_hasta -> '+idubicacion_hasta);
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
                    url: '../ajax/consultas.php?op=stockubicacionCF',
                    data:{idubicacion_desde:idubicacion_desde, idubicacion_hasta:idubicacion_hasta},
					//data:{},
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
$('#idubicacion_desde').on('change', function() {
	idubicacion_desde = $(this).val();
	//idarticulo = 1;
	//console.log("Por desde...");
	//Cargamos los items al select articulo
	$.post(
		"../ajax/ubicacion.php?op=selecthasta", 
		{idubicacion_desde:idubicacion_desde},
		function (r) 
		{
			$("#idubicacion_hasta").html(r);
			$('#idubicacion_hasta').prop('selectedIndex', 0);
			idubicacion_hasta = $('select[name=idubicacion_hasta] option').filter(':selected').val();
			$('#idubicacion_hasta').selectpicker('refresh');
		}
	)
	//console.log('idubicacion_hasta (método change idcategoria) al regresar del post -> '+idubicacion_hasta);
		
});
$('#idubicacion_hasta').on('change', function() {
	console.log("Por hasta...");
	idubicacion_hasta = $(this).val();
});