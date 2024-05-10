<?php
    
    require_once '../modelos/Subcategoria.php';

    $subcategoria = new Subcategoria();

    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
	$idsubcategoria=isset($_POST["idsubcategoria"])? limpiarCadena($_POST["idsubcategoria"]):"";
	$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
	$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idsubcategoria)){
                $rspta=$subcategoria->insertar($idcategoria, $nombre, $descripcion);
                echo $rspta ? "Subcategoria registrada" : "Subcategoría no se pudo registrar";
            }
            else {
                $rspta=$subcategoria->editar($idsubcategoria, $idcategoria, $nombre, $descripcion);
                echo $rspta ? "Subcategoria actualizada" : "Subcategoría no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $subcategoria->desactivar($idsubcategoria);
                echo $rspta ? "Subcategoria desactivada" : "Subcategoria no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $subcategoria->activar($idsubcategoria);
            echo $rspta ? "Subcategoria activada" : "Subcategoria no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $subcategoria->mostrar($idsubcategoria);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $subcategoria->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idsubcategoria.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idsubcategoria.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idsubcategoria.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idsubcategoria.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
					"3"=>$reg->categoria,
                    "4"=>($reg->condicion) ?
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
		
		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria = new Categoria();
	
			$rspta = $categoria->select();
	
			while ($reg = $rspta->fetch_object())
					{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
					}
		break;
		
		case 'selectSubCategorias':
			$rspta = $subcategoria->selectSCs($idcategoria);
	
			while ($reg = $rspta->fetch_object())
					{
					echo '<option value=' . $reg->idsubcategoria . '>' . $reg->nombre . '</option>';
					}
		break;
    }

?>