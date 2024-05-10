var tabla;
var idcategoria = 1;
var idarticulo = 1;

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
	//Cargamos los items al select articulo
	$.post(
		"../ajax/articulo.php?op=selectArticuloCategoria", 
		{idcategoria:idcategoria},
		function (r) 
		{
			$("#idarticulo").html(r);
			$('#idarticulo').val(idarticulo);
			$('#idarticulo').selectpicker('refresh');
		}
	)
}

function listar()
{
	//var idarticulo = $("#idarticulo").val();
	//var idcategoria = $("#idcategoria").val();
	//idcategoria = $("#idcategoria").val();

	console.log('Valor de idarticulo -> '+idarticulo);
	console.log('Valor de idcategoria -> '+idcategoria);

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
                    url: '../ajax/consultas.php?op=stockproducto',
                    data:{idarticulo:idarticulo},
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
	//idarticulo = 1;
	
	//Cargamos los items al select articulo
	$.post(
		"../ajax/articulo.php?op=selectArticuloCategoria", 
		{idcategoria:idcategoria},
		function (r) 
		{
			$("#idarticulo").html(r);
			$('#idarticulo').prop('selectedIndex', 0);
			idarticulo = $('select[name=idarticulo] option').filter(':selected').val();
			$('#idarticulo').selectpicker('refresh');
		}
	)
	console.log('idarticulo (método change idcategoria) al regresar del post -> '+idarticulo);
		
});

$('#idarticulo').on('change', function() {
	idarticulo = $(this).val();
});


