<?php
    require '../config/conexion.php';

    Class Persona 
    {
        public function __construct()
        {

        }

        public function insertar($tipo_persona,$nombre,$idsector,$tipo_documento,$num_documento,$direccion,$telefono,$email)
        {
            $sql = "INSERT INTO persona (
                    tipo_persona,
                    nombre,
					idsector,
                    tipo_documento,
                    num_documento,
                    direccion,
                    telefono,
                    email,
					condicion
                   ) 
                    VALUES (
                        '$tipo_persona',
                        '$nombre',
						'$idsector',
                        '$tipo_documento',
                        '$num_documento',
                        '$direccion',
                        '$telefono',
                        '$email',
						1
                        )";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idpersona,$tipo_persona,$nombre,$idsector,$tipo_documento,$num_documento,$direccion,$telefono,$email)
        {
            $sql = "UPDATE persona SET 
                    tipo_persona='$tipo_persona', 
                    nombre='$nombre',
                    idsector='$idsector',
					tipo_documento='$tipo_documento',
                    num_documento='$num_documento',
                    direccion='$direccion',
                    telefono='$telefono',
                    email='$email'
                    WHERE idpersona='$idpersona '";
            
            return ejecutarConsulta($sql);
        }

        
        public function eliminar($idpersona)
        {
            $sql= "DELETE FROM persona 
                   WHERE idpersona='$idpersona'";
            
            return ejecutarConsulta($sql);
        }

		
		public function desactivar($idpersona)
        {
            $sql= "UPDATE persona SET condicion='0' 
                   WHERE idpersona='$idpersona'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idpersona)
        {
            $sql= "UPDATE persona SET condicion='1' 
                   WHERE idpersona='$idpersona'";
            
            return ejecutarConsulta($sql);
        }
		
		
        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idpersona)
        {
            $sql = "SELECT * FROM persona 
                    WHERE idpersona='$idpersona'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarp()
        {
            $sql = "SELECT * FROM persona 
                    WHERE tipo_persona='Proveedor'";

            return ejecutarConsulta($sql);
        }
		
		public function listarpactivo()
        {
            $sql = "SELECT * FROM persona p
                    WHERE p.tipo_persona='Proveedor'
					AND p.condicion = 1";

            return ejecutarConsulta($sql);
        }

        public function listarc()
        {
            //$sql = "SELECT * FROM persona 
            //        WHERE tipo_persona='Cliente'";
			
			$sql= "SELECT 
					p.idpersona,
					p.tipo_persona,
					p.nombre,
					p.tipo_documento,
					p.num_documento,
					p.direccion,
					p.telefono,
					p.email,
					s.idsector,
					s.nombre as sector,
					p.condicion
					FROM
						persona p
					INNER JOIN
						sector s
					ON
						p.idsector = s.idsector
					WHERE p.tipo_persona='Cliente'";
			
			
            return ejecutarConsulta($sql);
        }
		
		public function listarcactivo()
        {
            //$sql = "SELECT * FROM persona 
            //        WHERE tipo_persona='Cliente'";
			
			$sql= "SELECT 
					p.idpersona,
					p.tipo_persona,
					p.nombre,
					p.tipo_documento,
					p.num_documento,
					p.direccion,
					p.telefono,
					p.email,
					s.idsector,
					s.nombre as sector,
					p.condicion
					FROM
						persona p
					INNER JOIN
						sector s
					ON
						p.idsector = s.idsector
					WHERE p.tipo_persona='Cliente'
					AND p.condicion = 1";
			
			
            return ejecutarConsulta($sql);
        }

    }

?>