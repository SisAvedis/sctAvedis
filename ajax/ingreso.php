<?php
    
    require_once '../modelos/Ingreso.php';
    
    if(strlen(session_id()) < 1){
        session_start();
    }

    $ingreso = new Ingreso();

    $idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
    $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
    $idusuario= $_COOKIE['idusuario'];
    $tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
    $serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
    $num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
    $fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
    $observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
    $total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

    $idarticulo = isset($_POST['idarticulo']) ? $_POST['idarticulo'] : "";
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
    $precio_compra =isset($_POST['precio_compra']) ? $_POST['precio_compra'] : "";
    //$precio_venta =isset($_POST['precio_venta']) ? $_POST['precio_venta'] : "";
	$precio_venta =0;

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idingreso)){
                $rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$observacion,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta);
                echo $rspta ? "Ingreso registrado" : "Ingreso no se pudo registrar";
            }
        break;

        case 'validar':
			//Validamos si hay existencia de articulo (en ubicacion REC)
			$rspta = $ingreso->validar($idingreso);
			echo json_encode($rspta);
		break;
		
		case 'anular':
            //Recibimos el idingreso
            $id=$_GET['id'];
			$rspta = $ingreso->anular($id);
			echo $rspta ? "Ingreso anulado" : "Ingreso no se pudo anular";
        break;

        case 'mostrar':
            $rspta = $ingreso->mostrar($idingreso);
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
            //Recibimos el idingreso
            $id=$_GET['id'];

            $rspta = $ingreso->listarDetalle($id);
            
            $total = 0;
            
            echo '<thead style="background-color:#A9D0F5">
                    <th>Opciones</th>
                    <th>Codigo</th>
					<th>Articulo</th>
					<th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Precio Compra</th>
                    <th>Subtotal</th>
                </thead>';

            while($reg = $rspta->fetch_object())
            {
                echo '<tbody>
                        <tr class="filas">
                            <td></td> 
							<td>'.$reg->codigo.'</td>
                            <td>'.$reg->nombre.'</td>
							<td>'.$reg->descripcion.'</td>
                            <td>'.$reg->cantidad.'</td> 
                            <td>'.$reg->precio_compra.'</td> 
                            <td>'.$reg->precio_compra * $reg->cantidad.'</td> 
                        </tr>
                      </tbody>';

                $total += ($reg->precio_compra*$reg->cantidad);
            }

            echo '<tfoot>
                    <th>TOTAL</th>
                    <th></th>
                    <th></th>
					<th></th>
                    <th></th>
                    <th></th>
                    <th>
                    <h4 id="total">$ '.$total.'</h4>
                    <input type="hidden" name="total_compra" id="total_compra">
                    </th>
                </tfoot>';

        break;

        case 'listar':
            $rspta = $ingreso->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado == 'Aceptado') ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><li class="fa fa-eye"></li></button>'.
                        ' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><li class="fa fa-eye"></li></button>',
                    "1"=>$reg->fecha,
                    "2"=>$reg->proveedor,
                    "3"=>$reg->usuario,
                    "4"=>$reg->tipo_comprobante,
                    "5"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
                    "6"=>$reg->total_compra,
                    "7"=>($reg->estado=='Aceptado') ?
                         '<span class="label bg-green">Aceptado</span>'
                         :      
                         '<span class="label bg-red">Anulado</span>'
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

        case 'selectProveedor':
            
            require_once '../modelos/Persona.php';
            $persona = new Persona();

            $rspta = $persona->listarpactivo();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
            }
        break;

        case 'listarArticulos':

            require_once '../modelos/Articulo.php';
            $articulo = new Articulo();

            $rspta = $articulo->listarActivosUbiModal();
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\','.$reg->idubicacion.')">
                                <span class="fa fa-plus"></span>
                            </button>',
                    "1"=>$reg->nombre,
					"2"=>$reg->descripcion,
                    "3"=>$reg->categoria,
					"4"=>$reg->subcategoria,
                    "5"=>$reg->codigo,
                    "6"=>$reg->stock,
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
			$rspta = $articulo->listarActivosIngresoUbiUnoId($idartubi);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\','.$reg->idubicacion.')">
                    <span class="fa fa-plus"></span>
                </button>',
                    "1"=>$reg->nombre,
					"2"=>$reg->descripcion,
                    "3"=>$reg->categoria,
					"4"=>$reg->subcategoria,
                    "5"=>$reg->codigo,
                    "6"=>$reg->stock,
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
    }

?>