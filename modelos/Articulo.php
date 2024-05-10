<?php
    require '../config/conexion.php';

    Class Articulo 
    {
        public function __construct()
        {

        }

        public function insertar($idcategoria,$idsubcategoria,$idunidad,$idusuario,$codigo,$nombre,$cantidad,$descripcion,$imagen)
        {
            $sql = "INSERT INTO 
                        articulo (
                            idcategoria,
							idsubcategoria,
							idunidad,
							idusuario,
                            codigo,
                            nombre,
                            cantidad,
                            descripcion,
                            imagen,
                            condicion
                        ) 
                    VALUES (
                        '$idcategoria',
						'$idsubcategoria',
						'$idunidad',
						'$idusuario',
                        '$codigo',
                        '$nombre',
                        '$cantidad',
                        '$descripcion',
                        '$imagen',
                        '1')";
            //echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }

        public function editar($idarticulo,$idcategoria,$idsubcategoria,$idunidad,$idusuario,$codigo,$nombre,$descripcion,$imagen)
        {
            $sql = "UPDATE articulo SET 
                    idcategoria ='$idcategoria',
					idsubcategoria ='$idsubcategoria',
					idunidad ='$idunidad',
                    idusuario ='$idusuario',
					codigo = '$codigo', 
                    nombre = '$nombre', 
                    descripcion = '$descripcion', 
                    imagen = '$imagen' 
                    WHERE idarticulo='$idarticulo'";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($idarticulo)
        {
            $sql= "UPDATE articulo SET condicion='0' 
                   WHERE idarticulo='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idarticulo)
        {
            $sql= "UPDATE articulo SET condicion='1' 
                   WHERE idarticulo='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idarticulo)
        {
            $sql = "SELECT 
					a.idarticulo,
					a.idusuario,
					a.nombre as nombre,
					a.idcategoria,
					CASE WHEN  sc.idsubcategoria IS NULL
					THEN (SELECT idsubcategoria FROM subcategoria WHERE idcategoria = a.idcategoria LIMIT 1)
					ELSE a.idsubcategoria
					END AS idsubcategoria,
					a.codigo as codigo,
					a.idunidad as idunidad,
					a.descripcion as descripcion,
					sa.stock as stock,
					a.imagen as imagen,
					a.condicion
					FROM articulo a
					INNER JOIN stockarticulo sa
					ON a.idarticulo = sa.idarticulo
					LEFT JOIN subcategoria sc
					ON a.idsubcategoria = sc.idsubcategoria
					WHERE a.idarticulo='$idarticulo'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					sc.nombre as subcategoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
                    a.nombre,
                    sa.stock,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
					INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					LEFT JOIN stockarticulo sa
					ON a.idarticulo = sa.idarticulo";

            return ejecutarConsulta($sql);
        }
		
		//Listar articulos de una categoria
        public function listarArticuloCategoria($idcategoria)
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
                    a.nombre,
                    sa.stock,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					LEFT JOIN stockarticulo sa
					ON a.idarticulo = sa.idarticulo
					WHERE a.idcategoria='$idcategoria'";

            return ejecutarConsulta($sql);
        }

        public function listarActivosArray($idartubi)

        
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					sc.nombre as subcategoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
					i.idubicacion,
					u.codigo AS c_ubi,
                    a.nombre,
                    i.cantidad,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
                    INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					INNER JOIN inventario i
					ON a.idarticulo = i.idarticulo
					INNER JOIN ubicacion u
					ON i.idubicacion = u.idubicacion
					WHERE a.condicion = '1'
					AND i.idubicacion <>'1'
					AND i.cantidad > 0
                    AND NOT a.idarticulo IN ('".$idartubi."')
                    GROUP BY a.idarticulo";

            return ejecutarConsulta($sql);
        }

        //Listar registros activos - _ingresos
        public function listarActivos()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					a.idsubcategoria, 
                    sc.nombre as subcategoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
                    a.nombre,
                    sa.stock,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a
					INNER JOIN stockarticulo sa
					ON a.idarticulo = sa.idarticulo
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
                    INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					WHERE a.condicion = '1'";

            return ejecutarConsulta($sql);
        }

        public function listarActivosVenta()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					sc.nombre as subcategoria,
                    a.codigo,
                    a.nombre,
                    a.stock,
                    (
                        SELECT precio_venta 
                        FROM detalle_ingreso
                        WHERE idarticulo = a.idarticulo
                        ORDER BY iddetalle_ingreso 
                        desc limit 0,1 

                    ) as precio_venta, 
                    a.descripcion,
                    a.imagen,
                    a.condicion
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
                    WHERE a.condicion = '1'";

            return ejecutarConsulta($sql);
        }

        public function listarActivosUbiModal()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					sc.nombre as subcategoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
					i.idubicacion,
					u.codigo AS c_ubi,
                    a.nombre,
                    sa.stock AS stock,
                    SUM(i.cantidad) AS cantidad,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
                    INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					INNER JOIN inventario i
					ON a.idarticulo = i.idarticulo
					INNER JOIN ubicacion u
					ON i.idubicacion = u.idubicacion
                    INNER JOIN stockarticulo sa
					ON a.idarticulo = sa.idarticulo
					WHERE a.condicion = '1'
					AND i.idubicacion <>'1'
					-- AND i.cantidad > 0
                    GROUP BY a.idarticulo";

            return ejecutarConsulta($sql);
        }

		//Listar registros activos
        public function listarActivosUbi()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
					sc.nombre as subcategoria,
                    a.idunidad, 
                    d.nombre as unidad,
					a.codigo,
					i.idubicacion,
					u.codigo AS c_ubi,
                    a.nombre,
                    i.cantidad,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
					LEFT JOIN subcategoria sc 
                    ON a.idsubcategoria = sc.idsubcategoria
                    INNER JOIN unidad d
					ON a.idunidad = d.idunidad
					INNER JOIN inventario i
					ON a.idarticulo = i.idarticulo
					INNER JOIN ubicacion u
					ON i.idubicacion = u.idubicacion
					WHERE a.condicion = '1'
					AND i.idubicacion <>'1'
					-- AND i.cantidad > 0
					ORDER BY a.idarticulo, u.codigo";

            return ejecutarConsulta($sql);
        }

        
		
		
		//Listar registros activos
        public function listarActivosUbiUno($idartubi)
        {
            $sql = "CALL prParseArrayv2('".$idartubi."')";
			//echo $sql."</br>";
            return ejecutarConsulta($sql);
        }

		//Listar registros activos
        public function listarActivosUbiDos($idartubi,$idcliente)
        {
            $sql = "CALL prParseArrayv4('".$idartubi."','".$idcliente."')";
			//echo $sql."</br>";
            return ejecutarConsulta($sql);
        }

        public function listarActivosUbiId($idarticulo)
        {
            $sql = "CALL prArticulosConteo('".$idarticulo."')
            "
                    ;

            return ejecutarConsulta($sql);
        }

        public function listarActivosUbiIdUno($idartubi, $idarticulo){
            $sql= "CALL prParseArrayv6('".$idartubi."',".$idarticulo.")";
            return ejecutarConsulta($sql);
        }

        public function listarActivosUbiUnoId($idartubi)
        {
            $sql = "CALL prParseArrayv5('".$idartubi."')";
			//echo $sql."</br>";
            return ejecutarConsulta($sql);
        }

        public function listarActivosIngresoUbiUnoId($idartubi)
        {
            $sql = "CALL prParseArrayIngresoUnoId('".$idartubi."')";
			//echo $sql."</br>";
            return ejecutarConsulta($sql);
        }


		//Listar registros activos
        public function listarActivosExt($idpersona)
        {
            $sql = "CALL `pr_listarArticuloDevolucion`('".$idpersona."')";
            return ejecutarConsulta($sql);
        }
        public function listarActivosExtRod($idrodado)
        {
            $sql = "CALL `pr_listarArticuloDevolucionRodado`('".$idrodado."')";
            return ejecutarConsulta($sql);
        }

		//METODO PARA LISTAR LOS REGISTROS
        public function listarSimple()
        {
            $sql = "SELECT idarticulo,codigo,nombre, descripcion FROM articulo";

            return ejecutarConsulta($sql);
        }

    }

?>