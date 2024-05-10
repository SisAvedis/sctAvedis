<?php
    
    require_once '../modelos/Persona.php';

    $persona = new Persona();

    $idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
    $tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $idsector=isset($_POST["idsector"])? limpiarCadena($_POST["idsector"]):"";
	$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
    $num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
    $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
	
	
    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idpersona)){
                $rspta=$persona->insertar($tipo_persona,$nombre,$idsector,$tipo_documento,$num_documento,$direccion,$telefono,$email);
                echo $rspta ? $tipo_persona." registrado" : $tipo_persona." no se pudo registrar";
            }
            else {
                $rspta=$persona->editar($idpersona,$tipo_persona,$nombre,$idsector,$tipo_documento,$num_documento,$direccion,$telefono,$email);
                echo $rspta ? $tipo_persona." actualizado" : $tipo_persona." no se pudo actualizar";
            } 
        break;

        case 'eliminar':
                $rspta = $persona->eliminar($idpersona,$tipo_persona);
                echo $rspta ? $tipo_persona." eliminado" : $tipo_persona." no se pudo eliminar";
        break;
		
		case 'desactivar':
                $rspta = $persona->desactivar($idpersona,$tipo_persona);
                echo $rspta ? $tipo_persona." desactivado" : $tipo_persona." no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $persona->activar($idpersona,$tipo_persona);
            echo $rspta ? $tipo_persona." activado" : $tipo_persona." no se pudo activar";
        break;
		
        case 'mostrar':
            $rspta = $persona->mostrar($idpersona);
            echo json_encode($rspta);
        break;

        case 'listarp':
            $rspta = $persona->listarp();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ?
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->tipo_documento,
                    "3"=>$reg->num_documento,
                    "4"=>$reg->telefono,
                    "5"=> $reg->email,
					"6"=>($reg->condicion) ?
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

        case 'listarc':
            $rspta = $persona->listarc();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>($reg->condicion) ?
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
					"2"=>$reg->sector,
                    "3"=>$reg->tipo_documento,
                    "4"=>$reg->num_documento,
                    "5"=>$reg->telefono,
                    "6"=> $reg->email,
					"7"=>($reg->condicion) ?
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
		
		case 'selectSector':
            require_once "../modelos/Sector.php";
            $sector = new Sector();

            $rspta = $sector->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idsector.'>'
                        .$reg->nombre.
                      '</option>';
            }
        break;
    }

?>