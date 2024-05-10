<?php
    require '../config/conexion.php';

    Class Consultas
    {
        public function __construct()
        {

        }

        public function comprafecha($fecha_inicio, $fecha_fin)
        {
            $sql = "SELECT 
                        DATE_FORMAT(i.fecha_hora,'%d-%m-%Y') as fecha,
                        u.nombre as usuario,
                        p.nombre as proveedor,
                        i.tipo_comprobante,
                        i.serie_comprobante,
                        i.num_comprobante,
                        i.total_compra,
                        i.impuesto,
                        i.estado
                    FROM
                        ingreso i
                    INNER JOIN persona p
                    ON i.idproveedor = p.idpersona
                    INNER JOIN usuario u
                    ON i.idusuario = u.idusuario
                    WHERE 
                        DATE(i.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(i.fecha_hora) <= '$fecha_fin'";

            return ejecutarConsulta($sql);
        }

		public function stock()
        {
            $sql = "SELECT 
                        i.idubicacion,
                        a.codigo as cod_art,
                        a.nombre as articulo,
						a.descripcion as descripcion,
                        u.codigo as cod_ubi,
                        u.descripcion as codigo,
                        i.cantidad
                    FROM
                        inventario i
                    INNER JOIN ubicacion u
                    ON i.idubicacion = u.idubicacion
                    INNER JOIN articulo a
                    ON i.idarticulo = a.idarticulo
                    WHERE 
						i.idubicacion <> 1
					AND
                        a.condicion = 1
					AND 
						i.cantidad > 0";
			//echo $sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		public function stockproducto($idarticulo)
        {
            $sql = "SELECT 
                        a.codigo as cod_art,
                        a.nombre as articulo,
						a.descripcion as descripcion,
                        SUM(i.cantidad) as cantidad
                    FROM
                        inventario i
                    INNER JOIN ubicacion u
                    ON i.idubicacion = u.idubicacion
                    INNER JOIN articulo a
                    ON i.idarticulo = a.idarticulo
                    WHERE 
						i.idubicacion <> 1
					AND
                        a.condicion = 1
					AND 
						a.idarticulo = '$idarticulo'
					GROUP BY a.idarticulo";
			
			//echo $sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		
		public function stockcategoria($idcategoria)
        {
            $sql = "SELECT 
                        a.codigo as cod_art,
                        a.nombre as articulo,
						a.descripcion as descripcion,
						u.codigo as cod_ubi,
                        SUM(i.cantidad) as cantidad
                    FROM
                        inventario i
                    INNER JOIN ubicacion u
                    ON i.idubicacion = u.idubicacion
                    INNER JOIN articulo a
                    ON i.idarticulo = a.idarticulo
                    WHERE 
						i.idubicacion <> 1
					AND
                        a.condicion = 1
					AND 
						a.idcategoria = '$idcategoria'
					GROUP BY a.idarticulo, u.codigo
					HAVING SUM(i.cantidad)";
			
			//echo $sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		
		public function stockubicacion($idubicacion_desde,$idubicacion_hasta)
        {
            $sql = "CALL prStockUbicacion('".$idubicacion_desde."','".$idubicacion_hasta."')";
			/*
			$sql = "SELECT a.codigo AS cod_art, a.nombre AS articulo, a.descripcion AS descripcion, u.codigo AS cod_ubi, SUM(i.cantidad) AS cantidad
         	FROM inventario i
            	INNER JOIN ubicacion u
               	ON i.idubicacion = u.idubicacion
                INNER JOIN articulo a
                  ON i.idarticulo = a.idarticulo
                  	WHERE i.idubicacion <> 1
						AND a.condicion = 1
							AND i.idubicacion = 10";
			
			*/
			
			
			
			
			
			
			//echo $sql.'</br>';
			return ejecutarConsulta($sql);
        }
		

        public function ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente)
        {
            $sql = "SELECT 
            dv.idventa,
            dv.idarticulo,
            p.nombre as operario,
            v.comentario,
            DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha_hora,
            v.serie_comprobante,
            v.num_comprobante,
            a.codigo,
            a.nombre,
            a.descripcion,
            dv.cantidad,
            uo.descripcion AS cod_origen,
            ud.descripcion AS cod_destino
            FROM detalle_venta dv
            INNER JOIN venta v 
            ON dv.idventa = v.idventa
            INNER JOIN persona p 
            ON v.idcliente = p.idpersona
            INNER JOIN articulo a 
            ON dv.idarticulo=a.idarticulo 
            INNER JOIN ubicacion uo
            ON dv.idubi_origen = uo.idubicacion
            INNER JOIN ubicacion ud
            ON dv.idubi_destino = ud.idubicacion
            WHERE v.fecha_hora BETWEEN DATE('$fecha_inicio') AND DATE('$fecha_fin')
            AND v.estado = 'Aceptado'
            AND v.idcliente = '$idcliente'";

            return ejecutarConsulta($sql);
        }
        public function ventassolofechacliente($fecha_inicio, $fecha_fin)
        {
            $sql = "SELECT 
            dv.idventa,
            dv.idarticulo,
            p.nombre as operario,
            v.comentario,
            DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha_hora,
            v.serie_comprobante,
            v.num_comprobante,
            a.codigo,
            a.nombre,
            a.descripcion,
            dv.cantidad,
            uo.descripcion AS cod_origen,
            ud.descripcion AS cod_destino
            FROM detalle_venta dv
            INNER JOIN venta v 
            ON dv.idventa = v.idventa
            INNER JOIN persona p 
            ON v.idcliente = p.idpersona
            INNER JOIN articulo a 
            ON dv.idarticulo=a.idarticulo 
            INNER JOIN ubicacion uo
            ON dv.idubi_origen = uo.idubicacion
            INNER JOIN ubicacion ud
            ON dv.idubi_destino = ud.idubicacion
            WHERE v.fecha_hora BETWEEN DATE('$fecha_inicio') AND DATE('$fecha_fin')
            AND v.estado = 'Aceptado'
           ";

            return ejecutarConsulta($sql);
        }
        public function ventasfecharodado($fecha_inicio, $fecha_fin, $idrodado)
        {
            $sql = "SELECT 
            dv.idventa,
            dv.idarticulo,
            r.dominio,
            v.comentario,
            DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha_hora,
            v.serie_comprobante,
            v.num_comprobante,
            a.codigo,
            a.nombre,
            a.descripcion,
            dv.cantidad,
            uo.descripcion AS cod_origen,
            ud.descripcion AS cod_destino
            FROM detalle_venta_rodado dv
            INNER JOIN venta_rodado v 
            ON dv.idventa = v.idventa
            INNER JOIN rodado r 
            ON v.idrodado = r.idrodado
            INNER JOIN articulo a 
            ON dv.idarticulo=a.idarticulo 
            INNER JOIN ubicacion uo
            ON dv.idubi_origen = uo.idubicacion
            INNER JOIN ubicacion ud
            ON dv.idubi_destino = ud.idubicacion
            WHERE v.idrodado = '$idrodado'
            AND v.estado = 'Aceptado'
            AND v.fecha_hora BETWEEN DATE('$fecha_inicio') AND DATE('$fecha_fin')";

            return ejecutarConsulta($sql);
        }

        public function ventassolofecharodado($fecha_inicio, $fecha_fin)
        {
            $sql = "SELECT 
            dv.idventa,
            dv.idarticulo,
            r.dominio,
            v.comentario,
            DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha_hora,
            v.serie_comprobante,
            v.num_comprobante,
            a.codigo,
            a.nombre,
            a.descripcion,
            dv.cantidad,
            uo.descripcion AS cod_origen,
            ud.descripcion AS cod_destino
            FROM detalle_venta_rodado dv
            INNER JOIN venta_rodado v 
            ON dv.idventa = v.idventa
            INNER JOIN rodado r 
            ON v.idrodado = r.idrodado
            INNER JOIN articulo a 
            ON dv.idarticulo=a.idarticulo 
            INNER JOIN ubicacion uo
            ON dv.idubi_origen = uo.idubicacion
            INNER JOIN ubicacion ud
            ON dv.idubi_destino = ud.idubicacion
            AND v.estado = 'Aceptado'
            AND v.fecha_hora BETWEEN DATE('$fecha_inicio') AND DATE('$fecha_fin')";

            return ejecutarConsulta($sql);
        }
		
		public function entregasfechaoperario($fecha_inicio, $fecha_fin, $idcliente)
        {
            $sql = "SELECT 
                        DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
                        v.tipo_comprobante,
                        v.serie_comprobante,
                        v.num_comprobante,
                        a.codigo,
						a.nombre,
						a.descripcion,
						dv.cantidad
                    FROM
                        venta v
                    INNER JOIN persona p
                    ON v.idcliente = p.idpersona
                    INNER JOIN detalle_venta dv
                    ON v.idventa = dv.idventa
					INNER JOIN articulo a
					ON dv.idarticulo = a.idarticulo
                    WHERE 
                        DATE(v.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(v.fecha_hora) <= '$fecha_fin'
                    AND
                        v.idcliente = '$idcliente'";

            return ejecutarConsulta($sql);
        }

        public function entregassolofechaoperario($fecha_inicio, $fecha_fin)
        {
            $sql = "SELECT 
                    DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
                    p.nombre as operario,
                            v.tipo_comprobante,
                    v.serie_comprobante,
                    v.num_comprobante,
                    a.codigo,
                    a.nombre,
                    a.descripcion,
                    dv.cantidad
                    
                                FROM
                    venta v
                    INNER JOIN persona p
                    ON v.idcliente = p.idpersona
                    INNER JOIN detalle_venta dv
                    ON v.idventa = dv.idventa
                    INNER JOIN articulo a
                    ON dv.idarticulo = a.idarticulo
                    WHERE 
                        DATE(v.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(v.fecha_hora) <= '$fecha_fin'
                       ";

            return ejecutarConsulta($sql);
        }
		
		
		public function entregasfechaoperariocategoria($fecha_inicio, $fecha_fin, $idcliente, $idcategoria)
        {
            $sql = "SELECT 
                        DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
                        v.tipo_comprobante,
                        v.serie_comprobante,
                        v.num_comprobante,
                        a.codigo,
						a.nombre,
						a.descripcion,
						dv.cantidad
                    FROM
                        venta v
                    INNER JOIN persona p
                    ON v.idcliente = p.idpersona
                    INNER JOIN detalle_venta dv
                    ON v.idventa = dv.idventa
					INNER JOIN articulo a
					ON dv.idarticulo = a.idarticulo
					INNER JOIN categoria c
					ON a.idcategoria = c.idcategoria
                    WHERE 
                        DATE(v.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(v.fecha_hora) <= '$fecha_fin'
                    AND
                        v.idcliente = '$idcliente'
					AND
                        c.idcategoria = '$idcategoria'";

            return ejecutarConsulta($sql);
        }
		
		public function entregasfechasectorcategoria($fecha_inicio, $fecha_fin, $idsector, $idcategoria)
        {
            $sql = "SELECT 
                        DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
                        v.tipo_comprobante,
                        v.serie_comprobante,
                        v.num_comprobante,
                        a.codigo,
						a.nombre,
						a.descripcion,
						dv.cantidad
                    FROM
                        venta v
                    INNER JOIN persona p
                    ON v.idsector = p.idpersona
                    INNER JOIN detalle_venta dv
                    ON v.idventa = dv.idventa
					INNER JOIN articulo a
					ON dv.idarticulo = a.idarticulo
					INNER JOIN categoria c
					ON a.idcategoria = c.idcategoria
                    WHERE 
                        DATE(v.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(v.fecha_hora) <= '$fecha_fin'
                    AND
                        v.idsector = '$idsector'
					AND
                        c.idcategoria = '$idcategoria'";

            return ejecutarConsulta($sql);
        }
		

		public function entregasfechaoperarioagrupado($fecha_inicio, $fecha_fin, $idcliente)
        {
            $sql = "SELECT 
                        DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
                        a.codigo,
						a.nombre,
						a.descripcion,
						SUM(dv.cantidad) AS cantidad
                    FROM
                        venta v
                    INNER JOIN persona p
                    ON v.idcliente = p.idpersona
                    INNER JOIN detalle_venta dv
                    ON v.idventa = dv.idventa
					INNER JOIN articulo a
					ON dv.idarticulo = a.idarticulo
                    WHERE 
                        DATE(v.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(v.fecha_hora) <= '$fecha_fin'
                    AND
						v.estado = 'Aceptado'
					AND
                        v.idcliente = '$idcliente'
					GROUP BY a.codigo";

            return ejecutarConsulta($sql);
        }
		
		public function devolucionesfechaoperario($fecha_inicio, $fecha_fin, $idcliente)
        {
            $sql = "SELECT 
                        DATE_FORMAT(d.fecha_hora,'%d-%m-%Y') as fecha,
                        d.tipo_comprobante,
                        d.serie_comprobante,
                        d.num_comprobante,
                        a.codigo,
						a.nombre,
						a.descripcion,
						dd.cantidad
                    FROM
                        devolucion d
                    INNER JOIN persona p
                    ON d.idcliente = p.idpersona
                    INNER JOIN detalle_devolucion dd
                    ON d.iddevolucion = dd.iddevolucion
					INNER JOIN articulo a
					ON dd.idarticulo = a.idarticulo
                    WHERE 
                        DATE(d.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(d.fecha_hora) <= '$fecha_fin'
                    AND
                        d.idcliente = '$idcliente'";

            return ejecutarConsulta($sql);
        }
		
		
		public function devolucionesfechaoperarioagrupado($fecha_inicio, $fecha_fin, $idcliente)
        {
            $sql = "SELECT 
                        DATE_FORMAT(d.fecha_hora,'%d-%m-%Y') as fecha,
                        a.codigo,
						a.nombre,
						a.descripcion,
						SUM(dd.cantidad) AS cantidad
                    FROM
                        devolucion d
                    INNER JOIN persona p
                    ON d.idcliente = p.idpersona
                    INNER JOIN detalle_devolucion dd
                    ON d.iddevolucion = dd.iddevolucion
					INNER JOIN articulo a
					ON dd.idarticulo = a.idarticulo
                    WHERE 
                        DATE(d.fecha_hora) >= '$fecha_inicio'
                    AND
                        DATE(d.fecha_hora) <= '$fecha_fin'
                    AND
						d.estado = 'Aceptado'
					AND
                        d.idcliente = '$idcliente'
					GROUP BY a.codigo";

            return ejecutarConsulta($sql);
        }
		
		public function pr_movimientosarticulo($fecha_inicio, $fecha_fin, $idarticulo)
        {
            $sql = "CALL pr_movimientosarticulo('".$fecha_inicio."','".$fecha_fin."','".$idarticulo."')";
			
			return ejecutarConsulta($sql);
        }

        public function totalCompraHoy()
        {
            $sql= "SELECT 
                        IFNULL(SUM(total_compra),0) as total_compra
                    FROM
                        ingreso
                    WHERE
                        DATE(fecha_hora) = curdate()
                        AND estado = 'Aceptado'";
            
            return ejecutarConsulta($sql);
        }

        public function totalVentaHoy()
        {
            $sql= "SELECT 
                        IFNULL(SUM(total_venta),0) as total_venta
                    FROM
                        venta
                    WHERE
                        DATE(fecha_hora) = curdate()";
            
            return ejecutarConsulta($sql);
        }


        public function comprasUlt10dias()
        {
            $sql= "SELECT 
                        CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,
                        SUM(total_compra) as total
                    FROM
                        ingreso
                        WHERE estado = 'Aceptado'
                    GROUP BY
                        fecha_hora 
                    ORDER BY
                        fecha_hora
                    ASC limit 0,10
                    ";
            
            return ejecutarConsulta($sql);
        }

        public function ventas12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);
            $sql= "SELECT  CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
            LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
     SUM(Total) as total
            FROM 
            (
            SELECT fecha_hora , COUNT(*) AS Total FROM venta WHERE estado = 'Aceptado' 
				AND fecha_hora BETWEEN date_format(DATE_ADD(CURDATE(), INTERVAL -11 MONTH),'%Y-%m-01')
				  AND CURDATE()
				
				GROUP BY fecha_hora
				UNION ALL 
				SELECT fecha_hora , COUNT(*) AS Total FROM venta_rodado WHERE estado = 'Aceptado' 
				AND fecha_hora BETWEEN date_format(DATE_ADD(CURDATE(), INTERVAL -11 MONTH),'%Y-%m-01')
				  AND CURDATE()
				GROUP BY fecha_hora
			
				
            
            ) t Group BY month(fecha_hora) 
            ORDER BY fecha_hora
			
			";
            
            return ejecutarConsulta($sql);
        }

    }

?>