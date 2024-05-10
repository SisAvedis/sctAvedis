<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";

$idubi_origen= isset($_POST['idubi_origen']) ? $_POST['idubi_origen'] :"";
$idubi_destino= isset($_POST['idubi_destino']) ? $_POST['idubi_destino'] :"";
    
$idusuario=$_COOKIE["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$idarticulo = isset($_POST['idarticulo']) ? $_POST['idarticulo'] : "";
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$impuesto=0;
			$total_venta=0;

			$rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$fecha_hora,$observacion,$impuesto,$total_venta,$idarticulo,$cantidad,$idubi_origen,$idubi_destino);
			echo $rspta ? "Entrega registrada" : "No se pudieron registrar todos los datos de la entrega";
		}
		else {
			echo $rspta ? "Error else guardar" : "Else guardar sin rspta";
		}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Entrega anulada" : "Entrega no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Codigo</th>
                                    <th>Artículo</th>
									<th>Descripcion</th>
                                    <th>Cantidad</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->codigo.'</td><td>'.htmlspecialchars($reg->nombre).'</td>><td>'.htmlspecialchars($reg->descripcion).'</td><td>'.$reg->cantidad.'</td><td>'.$reg->cod_origen.'</td><td>'.$reg->cod_destino.'</td></tr>';
					//descripcion).'</td><td>'.$reg->cantidad.'</td><td>'.$reg->cod_origen.'</td><td>'.$reg->cod_destino.'</td><td>'.$reg->subtotal.'</td></tr>';
					//$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
				}
		/*
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
		*/
		;
	break;

	case 'listarArticulosId':

		require_once '../modelos/Articulo.php';
		$articulo = new Articulo();
		
		$idarticulo=$_GET['idarticulo'];
		//$idartubi=$_GET['idarticulo'];
		$rspta = $articulo->listarActivosUbiId($idarticulo);
		$data = Array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0"=> ' <button type="button" class="btn btn-warning" onclick=" agregarPedido('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->c_ubi).'\','.$reg->cantidad.','.$reg->conteoFilas.')">
				<i class="fa fa-plus"></i>
			</button> ',
				
				"1"=>$reg->nombre,
				"2"=>$reg->descripcion,
				"3"=>$reg->cantidad,
				"4"=>$reg->c_ubi,
				"5"=>'<input type="hidden" value="'.$reg->conteoFilas.'" >',
				//"6"=>$reg->cantidad,
				//"7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
				//"8"=>$reg->codigo,
			);
		}
		$results = array(
			"sEcho"=>1, //Informacion para el datable
			"iTotalRecords" =>count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" =>$data
		);
		echo json_encode($results);

	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

		 while ($reg=$rspta->fetch_object())
		 {
			if($reg->tipo_comprobante=='Ticket')
			{
				$url = '../reportes/exTicket.php?id='; //Ruta del archivo exTicket
			}
			else
			{
				$url = '../reportes/exFactura.php?id='; //Ruta del archivo exFactura
			}

 			$data[]=array(
 				"0"=>(
					 ($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
						' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
						'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'
					 ).
					 '<a target="_blank" href="'.$url.$reg->idventa.'">
						  <button class="btn btn-info">
						 <i class="fa fa-file"></i>
						 </button>
					 </a>'
					 ,
 				"1"=>$reg->fecha,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>$reg->tipo_comprobante,
 				"5"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
 				"6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectMovDestino':
            require_once "../modelos/Movimiento.php";
            $movimiento = new Movimiento();

            $rspta = $movimiento->selectUno();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idubicacion.'>'
                        .$reg->codigo.' - '.$reg->descripcion.
                      '</option>';
            }
        break;

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarcactivo();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;
	
	case 'selectSector':
		require_once "../modelos/Sector.php";
		$sector = new Sector();

		$rspta = $sector->select();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idsector . '>' . $reg->nombre . '</option>';
				}
	break;
	
	case 'listarArticulos':

        require_once '../modelos/Articulo.php';
        $articulo = new Articulo();

        $rspta = $articulo->listarActivosUbiModal();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
               "0"=> '<a data-toggle="modal" href="#deposiModal"><button class="btn btn-warning" onclick="listarArticulosId('.$reg->idarticulo.'); agregarArticuloADeposito('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\',\''.$reg->c_ubi.'\','.$reg->cantidad.');  ">
                                <span class="fa fa-eye"></span>
                            </button></a>',
					
                "1"=>$reg->nombre,
				"2"=>$reg->descripcion,
                "3"=>$reg->categoria,
				"4"=>$reg->subcategoria,
                "5"=>$reg->codigo,
                "6"=>$reg->cantidad,
                "7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
             );
        }
        $results = array(
            "sEcho"=>1, //Informacion para el datable
            "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" =>$data
        );
        echo json_encode($results);

    break;
	
	case 'listarArticulosUno':

            require_once '../modelos/Articulo.php';
            $articulo = new Articulo();
			
			$idartubi=$_GET['idartubi'];	
			$rspta = $articulo->listarActivosUbiUnoId($idartubi);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<a data-toggle="modal" href="#deposiModal"><button class="btn btn-warning" onclick=" controlIdUno('.$reg->idarticulo.'); agregarArticuloADeposito('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\',\''.$reg->c_ubi.'\','.$reg->cantidad.');">
                                <span class="fa fa-eye"></span>
                            </button></a>',
					
                    "1"=>$reg->nombre,
					"2"=>$reg->descripcion,
                    "3"=>$reg->categoria,
					"4"=>$reg->subcategoria,
                    "5"=>$reg->codigo,
                    "6"=>$reg->cantidad,
                    "7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);

        break;
		
		case 'listarArticulosIdUno':

			require_once '../modelos/Articulo.php';
			$articulo = new Articulo();
			
			$idarticulo=$_GET['idarticulo'];
			$idartubi=$_GET['idartubi'];
			$rspta = $articulo->listarActivosUbiIdUno($idartubi, $idarticulo);
			$data = Array();
	
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=> '
					 <button type="button" class="btn btn-warning" onclick=" agregarPedido('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->c_ubi).'\','.$reg->cantidad.','.$reg->conteoFilas.')">
					<i class="fa fa-plus"></i>
				</button>  ',
					
					"1"=>$reg->nombre,
					"2"=>$reg->descripcion,
					"3"=>$reg->cantidad,
					"4"=>$reg->c_ubi,
					"5"=>'<input type="hidden" value="'.$reg->conteoFilas.'" >',
				//	"6"=>'<td ></td>',
					//"7"=>'<td ></td>'
				);
			}
			$results = array(
				"sEcho"=>1, //Informacion para el datable
				"iTotalRecords" =>count($data), //enviamos el total de registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
				"aaData" =>$data
			);
			echo json_encode($results);
	
		break;
	
	
		case 'listarUbicacionesCodigo':
			require_once "../modelos/Ubicacion.php";
			$ubicacion=new Ubicacion();
	
			$rspta=$ubicacion->mostrar($idubi_destino);
			 //Vamos a declarar un array
			 $data= Array();
	
			 while ($reg=$rspta->fetch_object()){
				 $data[]=array(
					 "0"=>$reg->codigo,
					 );
			 }
			 $results = array(
				 "sEcho"=>1, //Información para el datatables
				 "iTotalRecords"=>count($data), //enviamos el total registros al datatable
				 "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				 "aaData"=>$data);
			 echo json_encode($results);
		break;


		case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
				"2"=>$reg->descripcion,
 				"3"=>$reg->categoria,
 				"4"=>$reg->codigo,
 				"5"=>$reg->stock,
 				"6"=>$reg->precio_venta,
 				"7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
	
}
?>