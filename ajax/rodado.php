<?php
    
    require_once '../modelos/Rodado.php';

    $rodado = new Rodado();

    $idrodado=isset($_POST["idrodado"])? limpiarCadena($_POST["idrodado"]):"";
	$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";
	$modelo=isset($_POST["modelo"])? limpiarCadena($_POST["modelo"]):"";
	$dominio=isset($_POST["dominio"])? limpiarCadena($_POST["dominio"]):"";
	$chasis=isset($_POST["chasis"])? limpiarCadena($_POST["chasis"]):"";
	$motor=isset($_POST["motor"])? limpiarCadena($_POST["motor"]):"";
	$idtipo_rodado=isset($_POST["idtipo_rodado"])? limpiarCadena($_POST["idtipo_rodado"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idrodado)){
                $rspta=$rodado->insertar($marca,$modelo,$dominio,$idtipo_rodado,$chasis,$motor);
                echo $rspta ? "Rodado registrado" : "Rodado no se pudo registrar";
            }
            else {
                $rspta=$rodado->editar($idrodado,$marca,$modelo,$dominio,$idtipo_rodado,$chasis,$motor);
                echo $rspta ? "Rodado actualizado" : "Rodado no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $rodado->desactivar($idrodado);
                echo $rspta ? "Rodado desactivado" : "Rodado no se pudos desactivar";
        break;

        case 'activar':
            $rspta = $rodado->activar($idrodado);
            echo $rspta ? "Rodado activado" : "Rodado no se pudos activar";
        break;

        case 'mostrar':
            $rspta = $rodado->mostrar($idrodado);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $rodado->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idrodado.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idrodado.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idrodado.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idrodado.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->marca,
                    "2"=>$reg->modelo,
					"3"=>$reg->dominio,
					"4"=>$reg->tiporodado,
                    "5"=>($reg->condicion) ?
                         '<span class="label bg-green">Activado</span>'
                         :      
                         '<span class="label bg-red">Desactivado</span>'
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
		
		/*
		case 'selectTipoRodado':
            require_once "../modelos/TipoRodado.php";
            $tiporodado = new TipoRodado();

            $rspta = $tiporodado->selectTipoRodado();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtipo_rodado.'>'
                        .$reg->nombre.
                      '</option>';
            }
        break;
		*/
		
		case 'selectRodado':
            
            $rspta = $rodado->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idrodado.'>'
                        .$reg->marca.' - '.$reg->dominio.
                      '</option>';
            }
        break;
		
    }

?>