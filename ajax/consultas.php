<?php
    
    require_once '../modelos/Consultas.php';

    $consulta = new Consultas();

    switch($_GET["op"])
    {

        case 'comprasfecha':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];

            $rspta = $consulta->comprafecha($fecha_inicio, $fecha_fin);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
                    "2"=>$reg->proveedor,
                    "3"=>$reg->tipo_comprobante,
                    "4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "5"=>$reg->total_compra,
                    "6"=>$reg->impuesto,
                    "7"=>($reg->estado== 'Aceptado') ?
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
		
		
		case 'stockproducto':
			$idarticulo = $_GET['idarticulo'];
            $rspta = $consulta->stockproducto($idarticulo);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->cod_art,
                    "1"=>$reg->articulo,
					"2"=>$reg->descripcion,
                    "3"=>$reg->cantidad
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
		
		
		case 'stockcategoria':
			$idcategoria = $_GET['idcategoria'];
            $rspta = $consulta->stockcategoria($idcategoria);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->cod_art,
                    "1"=>$reg->articulo,
					"2"=>$reg->descripcion,
					"3"=>$reg->cod_ubi,
                    "4"=>$reg->cantidad
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
		
		
		case 'stockubicacion':

            //$fecha_inicio = $_REQUEST["fecha_inicio"];
            //$fecha_fin = $_REQUEST["fecha_fin"];

            $rspta = $consulta->stock();
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->cod_art,
                    "1"=>$reg->articulo,
					"2"=>$reg->descripcion,
                    "3"=>$reg->cod_ubi,
                    "4"=>$reg->codigo,
					"5"=>$reg->cantidad
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
		
		
		case 'stockubicacionCF':

            $idubicacion_desde = $_REQUEST["idubicacion_desde"];
            $idubicacion_hasta = $_REQUEST["idubicacion_hasta"];

            $rspta = $consulta->stockubicacion($idubicacion_desde,$idubicacion_hasta);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->cod_art,
                    "1"=>$reg->articulo,
					"2"=>$reg->descripcion,
                    "3"=>$reg->cod_ubi,
                    "4"=>$reg->cantidad
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
		

        case 'ventasfechacliente':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            $rspta = $consulta->ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[]=array(
                    "0"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
                    "1"=>$reg->fecha_hora,
                    "2"=>$reg->comentario,
                    "3"=>$reg->operario,
                    "4"=>$reg->nombre,
                    "5"=>$reg->descripcion,
                    "6"=>$reg->cantidad,
                   "7"=>$reg->cod_origen,
                   "8"=>$reg->cod_destino,
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
        case 'ventassolofechacliente':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];

            $rspta = $consulta->ventassolofechacliente($fecha_inicio, $fecha_fin);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[]=array(
                    "0"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
                    "1"=>$reg->fecha_hora,
                    "2"=>$reg->comentario,
                    "3"=>$reg->operario,
                    "4"=>$reg->nombre,
                    "5"=>$reg->descripcion,
                    "6"=>$reg->cantidad,
                    "7"=>$reg->cod_origen,
                    "8"=>$reg->cod_destino,
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

        case 'ventasfecharodado':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idrodado = $_REQUEST["idrodado"];

            $rspta = $consulta->ventasfecharodado($fecha_inicio, $fecha_fin, $idrodado);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[]=array(
                    "0"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
                    "1"=>$reg->fecha_hora,
                    "2"=>$reg->comentario,
                    "3"=>$reg->dominio,
                    "4"=>$reg->nombre,
                    "5"=>$reg->descripcion,
                    "6"=>$reg->cantidad,
                   "7"=>$reg->cod_origen,
                   "8"=>$reg->cod_destino,
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
        case 'ventassolofecharodado':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];

            $rspta = $consulta->ventassolofecharodado($fecha_inicio, $fecha_fin);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[]=array(
                    "0"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
                    "1"=>$reg->fecha_hora,
                    "2"=>$reg->comentario,
                    "3"=>$reg->dominio,
                    "4"=>$reg->nombre,
                    "5"=>$reg->descripcion,
                    "6"=>$reg->cantidad,
                   "7"=>$reg->cod_origen,
                   "8"=>$reg->cod_destino,
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

		case 'entregasfechaoperario':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            $rspta = $consulta->entregasfechaoperario($fecha_inicio, $fecha_fin, $idcliente);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->tipo_comprobante,
                    "2"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "3"=>$reg->codigo,
					"4"=>$reg->nombre,
					"5"=>$reg->descripcion,
                    "6"=>$reg->cantidad
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
        
		
		
		case 'entregasfechaoperariocategoria':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];
			$idcategoria = $_REQUEST["idcategoria"];

            $rspta = $consulta->entregasfechaoperariocategoria($fecha_inicio, $fecha_fin, $idcliente,$idcategoria);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->tipo_comprobante,
                    "2"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "3"=>$reg->codigo,
					"4"=>$reg->nombre,
					"5"=>$reg->descripcion,
                    "6"=>$reg->cantidad
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
		
		
		case 'entregasfechasectorcategoria':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idsector = $_REQUEST["idsector"];
			$idcategoria = $_REQUEST["idcategoria"];

            $rspta = $consulta->entregasfechasectorcategoria($fecha_inicio, $fecha_fin, $idsector,$idcategoria);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->tipo_comprobante,
                    "2"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "3"=>$reg->codigo,
					"4"=>$reg->nombre,
					"5"=>$reg->descripcion,
                    "6"=>$reg->cantidad
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
		
		
		case 'entregasfechaoperarioagrupado':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            $rspta = $consulta->entregasfechaoperarioagrupado($fecha_inicio, $fecha_fin, $idcliente);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->codigo,
					"2"=>$reg->nombre,
					"3"=>$reg->descripcion,
                    "4"=>$reg->cantidad
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
				
			
		case 'devolucionesfechaoperario':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            $rspta = $consulta->devolucionesfechaoperario($fecha_inicio, $fecha_fin, $idcliente);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->tipo_comprobante,
                    "2"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "3"=>$reg->codigo,
					"4"=>$reg->nombre,
					"5"=>$reg->descripcion,
                    "6"=>$reg->cantidad
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
		
		case 'devolucionesfechaoperarioagrupado':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            $rspta = $consulta->devolucionesfechaoperarioagrupado($fecha_inicio, $fecha_fin, $idcliente);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->codigo,
					"2"=>$reg->nombre,
					"3"=>$reg->descripcion,
                    "4"=>$reg->cantidad
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
		
		
		case 'pr_movimientosarticulo':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idarticulo = $_REQUEST["idarticulo"];

            $rspta = $consulta->pr_movimientosarticulo($fecha_inicio, $fecha_fin, $idarticulo);
			//$rspta = $consulta->pr_movimientosarticulo($idarticulo);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->tipo_comprobante,
                    "2"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                    "3"=>$reg->origen,
					"4"=>$reg->destino,
                    "5"=>$reg->cantidad
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