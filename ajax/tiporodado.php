<?php
    
    require_once '../modelos/TipoRodado.php';

    $tiporodado = new TipoRodado();

    $idtipo_rodado=isset($_POST["idtipo_rodado"])? limpiarCadena($_POST["idtipo_rodado"]):"";
	$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
	$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idtipo_rodado)){
                $rspta=$tiporodado->insertar($nombre,$descripcion);
                echo $rspta ? "Tipo de Rodado registrado" : "Tipo de Rodado no se pudo registrar";
            }
            else {
                $rspta=$tiporodado->editar($idtipo_rodado,$nombre,$descripcion);
                echo $rspta ? "Tipo de Rodado actualizado" : "Tipo de Rodado no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $tiporodado->desactivar($idtipo_rodado);
                echo $rspta ? "Tipo de Rodado desactivado" : "Tipo de Rodado no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $tiporodado->activar($idtipo_rodado);
            echo $rspta ? "Tipo de Rodado activado" : "Tipo de Rodado no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $tiporodado->mostrar($idtipo_rodado);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $tiporodado->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipo_rodado.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idtipo_rodado.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipo_rodado.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idtipo_rodado.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>($reg->condicion) ?
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
		
		case 'selectTipoRodado':
            require_once "../modelos/TipoRodado.php";
            $tiporodado = new TipoRodado();

            $rspta = $tiporodado->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtipo_rodado.'>'
                        .$reg->nombre.
                      '</option>';
            }
        break;		
    }

?>