<?php
    require '../config/conexion.php';

    Class TipoRodado 
    {
        public function __construct()
        {

        }

        public function insertar($nombre, $descripcion)
        {
            $sql = "INSERT INTO tipo_rodado (nombre,descripcion,condicion) 
                    VALUES ('$nombre','$descripcion','1')";
            
			return ejecutarConsulta($sql);
        }

        public function editar($idtipo_rodado,$nombre, $descripcion)
        {
            $sql = "UPDATE tipo_rodado SET nombre='$nombre', descripcion='$descripcion'
                    WHERE idtipo_rodado='$idtipo_rodado'";
            
			return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivar($idtipo_rodado)
        {
            $sql= "UPDATE tipo_rodado SET condicion='0' 
                   WHERE idtipo_rodado='$idtipo_rodado'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idtipo_rodado)
        {
            $sql= "UPDATE tipo_rodado SET condicion='1' 
                   WHERE idtipo_rodado='$idtipo_rodado'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idtipo_rodado)
        {
            $sql = "SELECT * FROM tipo_rodado 
                    WHERE idtipo_rodado='$idtipo_rodado'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT * FROM tipo_rodado";

            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function select()
        {
            $sql = "SELECT * FROM tipo_rodado 
                    WHERE condicion = 1";

            return ejecutarConsulta($sql);
        }
    }

?>