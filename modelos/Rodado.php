<?php
    require '../config/conexion.php';

    Class Rodado 
    {
        public function __construct()
        {

        }

        public function insertar($marca,$modelo,$dominio,$idtipo_rodado,$chasis,$motor)
        {
            $sql = "INSERT INTO rodado (marca,modelo,dominio,idtipo_rodado,condicion,chasis,motor) 
                    VALUES ('$marca','$modelo','$dominio','$idtipo_rodado','1', '$chasis','$motor')";
            
			return ejecutarConsulta($sql);
        }

        public function editar($idrodado,$marca,$modelo,$dominio,$idtipo_rodado,$chasis,$motor)
        {
            $sql = "UPDATE rodado SET marca='$marca', modelo='$modelo', dominio='$dominio', idtipo_rodado='$idtipo_rodado', chasis='$chasis', motor='$motor'
                    WHERE idrodado='$idrodado'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR RODADOS
        public function desactivar($idrodado)
        {
            $sql= "UPDATE rodado SET condicion='0' 
                   WHERE idrodado='$idrodado'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idrodado)
        {
            $sql= "UPDATE rodado SET condicion='1' 
                   WHERE idrodado='$idrodado'";
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idrodado)
        {
            $sql = "SELECT * FROM rodado 
                    WHERE idrodado='$idrodado'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql= "SELECT 
					r.idrodado,
					r.marca,
					r.modelo,
					r.dominio,
					tr.nombre AS tiporodado,
					r.condicion,
                    r.chasis,
                    r.motor
					FROM
						rodado r
					INNER JOIN
						tipo_rodado tr
					ON
						r.idtipo_rodado = tr.idtipo_rodado";
			
			
			
			
			
            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function select()
        {
            $sql = "SELECT * FROM rodado 
                    WHERE condicion = 1
					ORDER BY marca,modelo";

            return ejecutarConsulta($sql);
        }
		
    }

?>