<?php
    require '../config/conexion.php';

    Class Subcategoria 
    {
        public function __construct()
        {

        }

        public function insertar($idcategoria, $nombre, $descripcion)
        {
            $sql = "INSERT INTO subcategoria (idcategoria,nombre,descripcion,condicion) 
                    VALUES ('$idcategoria','$nombre','$descripcion','1')";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }

        public function editar($idSubcategoria,$idcategoria, $nombre, $descripcion)
        {
            $sql = "UPDATE subcategoria SET nombre='$nombre', descripcion='$descripcion', idcategoria = '$idcategoria'
                    WHERE idsubcategoria='$idSubcategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivar($idSubcategoria)
        {
            $sql= "UPDATE subcategoria SET condicion='0' 
                   WHERE idsubcategoria='$idSubcategoria'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idSubcategoria)
        {
            $sql= "UPDATE subcategoria SET condicion='1' 
                   WHERE idsubcategoria='$idSubcategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idSubcategoria)
        {
            $sql = "SELECT sc.idsubcategoria, sc.nombre, sc.descripcion, sc.idcategoria, c.nombre AS categoria, sc.condicion FROM subcategoria sc
					INNER JOIN categoria c
					ON sc.idcategoria = c.idcategoria 
                    WHERE idsubcategoria='$idSubcategoria'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT sc.idsubcategoria, sc.nombre, sc.descripcion, c.nombre AS categoria, sc.condicion FROM subcategoria sc
					INNER JOIN categoria c
					ON sc.idcategoria = c.idcategoria";

            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function select()
        {
            $sql = "SELECT * FROM subcategoria 
                    WHERE condicion = 1";

            return ejecutarConsulta($sql);
        }
		
		//METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function selectSCs($idcategoria)
        {
            $sql = "SELECT * FROM subcategoria 
                    WHERE idcategoria='$idcategoria'
					AND condicion = 1";

            return ejecutarConsulta($sql);
        }
		
		
    }

?>