<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idrodado,$idusuario,$tipo_comprobante,$fecha_hora,$observacion,$impuesto,$total_venta,$idarticulo,$cantidad,$idubi_origen,$idubi_destino)
	{
		
			$sql = "SELECT valor FROM numerador_serie WHERE idnumerador = 6";
            //Devuelve serie comprobante
			$serie_comprobante =  ejecutarConsultaSimpleFila($sql);
			$sql = "SELECT valor + 1 AS valor FROM numerador_comprobante WHERE idnumerador = 6";
            //Devuelve número comprobante
			$num_comprobante =  ejecutarConsultaSimpleFila($sql);
			/*
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			*/

			
			$sql="INSERT INTO venta_rodado (
				idrodado,
				idusuario,
				tipo_comprobante,
				serie_comprobante,
				num_comprobante,
				fecha_hora,
				comentario,
				estado
				)
				VALUES (
					'$idrodado',
					'$idusuario',
					'$tipo_comprobante',
					'$serie_comprobante[valor]',
                    '$num_comprobante[valor]',
                    '$fecha_hora',
					'$observacion',
					'Aceptado')";
		
		$idventanew=ejecutarConsulta_retornarID($sql);
		
		//echo 'Variable sql -> '.$sql.'</br>';
		//echo 'Variable idventanew -> '.$idventanew.'</br>';
		
		$sql= "UPDATE numerador_comprobante SET valor='$num_comprobante[valor]' 
                   WHERE idnumerador=6";
        //echo 'Variable sql -> '.$sql.'</br>';
        ejecutarConsulta($sql) or $sw = false;
		
		$num_elementos=0;
		$sw=true;

		while (is_countable($idarticulo) && $num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta_rodado (
								idventa, 
								idarticulo,
								cantidad,
								idubi_origen,
								idubi_destino
							   ) 
							   VALUES (
								   '$idventanew', 
								   '$idarticulo[$num_elementos]',
								   '$cantidad[$num_elementos]',
								   '$idubi_origen[$num_elementos]',
								   '$idubi_destino[$num_elementos]'
								   )";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		//echo 'Variable sql_detalle -> '.$sql_detalle.'</br>';
		
		return $sw;
	}

	
	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta_rodado 
			  SET estado='Anulado' 
			  WHERE idventa='$idventa'";

		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT 
					v.idventa,
					DATE(v.fecha_hora) as fecha,
					v.idrodado,
					r.marca as rodado,
					u.idusuario,
					u.nombre as usuario,
					v.tipo_comprobante,
					v.serie_comprobante,
					v.num_comprobante,
					v.comentario,
					v.estado 
			    FROM venta_rodado v 
				INNER JOIN rodado r 
				ON v.idrodado=r.idrodado 
				INNER JOIN usuario u 
				ON v.idusuario=u.idusuario 
				WHERE v.idventa='$idventa'";

			return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT 
				dv.idventa,
				dv.idarticulo,
				a.codigo,
				a.nombre,
				a.descripcion,
				dv.cantidad,
				uo.codigo AS cod_origen,
				ud.codigo AS cod_destino
				FROM detalle_venta_rodado dv 
				INNER JOIN articulo a 
				ON dv.idarticulo=a.idarticulo 
				INNER JOIN ubicacion uo
				ON dv.idubi_origen = uo.idubicacion
				INNER JOIN ubicacion ud
				ON dv.idubi_destino = ud.idubicacion
				where dv.idventa='$idventa'";

		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
					v.idventa,
					DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
					v.idrodado,
					r.marca,
					r.dominio,
					u.idusuario,
					u.nombre as usuario,
					v.comentario,
					v.tipo_comprobante,
					v.serie_comprobante,
					v.num_comprobante,
					v.estado 
			   FROM venta_rodado v 
			   INNER JOIN rodado r 
			   ON v.idrodado=r.idrodado 
			   INNER JOIN usuario u 
			   ON v.idusuario=u.idusuario 
			   ORDER by v.idventa desc";
			   
		return ejecutarConsulta($sql);		
	}

	public function ventaCabecera($idventa)
	{
		$sql= "SELECT 
				v.idventa,
				v.idrodado,
				r.marca as marca,
				v.idusuario,
				u.nombre as usuario,
				v.tipo_comprobante,
				v.serie_comprobante,
				v.num_comprobante,
				DATE_FORMAT(v.fecha_hora,'%d-%m-%Y') as fecha,
				v.comentario
			  FROM
			  	venta_rodado v
			  INNER JOIN
			  	rodado r
			  ON
			  	v.idrodado = r.idrodado
			  INNER JOIN
			  	usuario u
			  ON
			  	v.idusuario = u.idusuario
		      WHERE
			  	v.idventa = '$idventa'";

		return ejecutarConsulta($sql);
	}
	
	public function ventaDetalle($idventa)
	{
		$sql = "SELECT
					a.nombre as articulo,
					a.codigo,
					dv.cantidad,
					uo.codigo AS cod_origen
					
				FROM
					detalle_venta_rodado dv
				INNER JOIN	
					articulo a
				ON
					dv.idarticulo = a.idarticulo
				INNER JOIN ubicacion uo
				ON 
					dv.idubi_origen = uo.idubicacion
				
				WHERE
					dv.idventa = '$idventa'";

		return ejecutarConsulta($sql);
	}

	public function ventaPorFecha($idrodado,$fecha_inicio,$fecha_fin){
		$sql = "SELECT 
		dv.idventa,
		dv.idarticulo,
		r.dominio,
		v.comentario,
		v.fecha_hora,
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
		WHERE v.fecha_hora BETWEEN '$fecha_inicio' AND '$fecha_fin'
		AND v.estado = 'Aceptado'
		AND v.idrodado = '$idrodado'";

		return ejecutarConsulta($sql);
	}
}
?>