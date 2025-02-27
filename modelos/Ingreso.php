<?php
    require '../config/conexion.php';

    Class Ingreso 
    {
        public function __construct()
        {

        }

        public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$observacion,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
        {
            $sql = "INSERT INTO ingreso (
                        idproveedor,
                        idusuario,
                        tipo_comprobante,
                        serie_comprobante,
                        num_comprobante,
                        fecha_hora,
                        observacion,
                        total_compra,
                        estado
                    ) 
                    VALUES (
                        '$idproveedor',
                        '$idusuario',
                        '$tipo_comprobante',
                        '$serie_comprobante',
                        '$num_comprobante',
                        '$fecha_hora',
                        '$observacion',
                        '$total_compra',
                        'Aceptado'
                        )";
            
            //Devuelve id registrado
            $idingresonew = ejecutarConsulta_retornarID($sql);
			//echo $idingresonew."</br>"; 
            //echo $idarticulo[0]."</br>"; 
			//echo $cantidad[0]."</br>"; 
			$num_elementos = 0;
            $sw = true;

            while(is_countable($idarticulo) && $num_elementos < count($idarticulo))
            {
                $sql_detalle ="INSERT INTO detalle_ingreso (
                                    idingreso,
                                    idarticulo,
                                    cantidad,
                                    precio_compra,
                                    precio_venta
                                )
                                VALUES (
                                    '$idingresonew',
                                    '$idarticulo[$num_elementos]',
                                    '$cantidad[$num_elementos]',
                                    '$precio_compra[$num_elementos]',
                                    '$precio_venta'
                                )";
					
				//echo $sql_detalle."</br>";
                ejecutarConsulta($sql_detalle) or $sw = false;

                $num_elementos = $num_elementos + 1;
            }
			//echo $sw."</br>";
            return $sw;
			
        }

        public function validar($idingreso)
        {
            $sql = "CALL pr_validarExistencia('".$idingreso."')";
            
            return ejecutarConsultaSimpleFila($sql);
        }
		
		public function anular($idingreso)
        {
 			$sql="UPDATE ingreso 
					SET estado='Anulado' 
					WHERE idingreso='$idingreso'";
			echo $sql."</br>";
            return ejecutarConsulta($sql);
        }
    
        public function mostrar($idingreso)
        {
            $sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor,p.nombre as proveedor, u.idusuario, u.nombre as usuario,
                            i.tipo_comprobante,i.serie_comprobante,i.num_comprobante, i.total_compra, i.observacion, i.estado 
                    FROM ingreso i
                    INNER JOIN persona p ON i.idproveedor = p.idpersona
                    INNER JOIN usuario u ON i.idusuario = u.idusuario
                    WHERE i.idingreso='$idingreso'";

            return ejecutarConsultaSimpleFila($sql);
        }

        public function listarDetalle($idingreso)
        {
            $sql = "SELECT di.idingreso, di.idarticulo, a.codigo, a.nombre, a.descripcion, di.cantidad, di.precio_compra,di.precio_venta
                    FROM detalle_ingreso di
                    INNER JOIN articulo a ON di.idarticulo = a.idarticulo
                    WHERE di.idingreso='$idingreso'";

            return ejecutarConsulta($sql);
        }

        public function listar()
        {
            $sql = "SELECT i.idingreso, DATE_FORMAT(i.fecha_hora,'%d-%m-%Y') as fecha, i.idproveedor,p.nombre as proveedor, u.idusuario, u.nombre as usuario,
                            i.tipo_comprobante,i.serie_comprobante,i.num_comprobante, i.total_compra, i.observacion, i.estado 
                    FROM ingreso i
                    INNER JOIN persona p ON i.idproveedor = p.idpersona
                    INNER JOIN usuario u ON i.idusuario = u.idusuario
                    ORDER BY i.idingreso desc";

            return ejecutarConsulta($sql);
        }
		
		
    }

?>