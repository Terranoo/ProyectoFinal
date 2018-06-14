<?php  
require "../resources/db_config";
class Service {
	private $servicio;
	private $db;

	public function __construct() {
		$this->servicio=array();
		$this->db=new mysqli(DB_SERVIDOR, DB_USUARIO, DB_PASS, DB_DB);
                $this->db->query("SET NAMES 'utf8'");
	}

        public function altaUsuario($nom, $ape, $pass, $seg, $dir, $cp, $loc, $pro, $tel, $ema) {
		$query = "INSERT INTO usuarios (nombre, apellidos, contrasenya, nivelSeguridad, Direccion, cp, Localidad, Provincia, telefono, email)". 
                        " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->db->prepare($query);
                $stmt->bind_param("sssissssss", $nom, $ape, $pass, $seg, $dir, $cp, $loc, $pro, $tel, $ema);
		$result = $stmt->execute();
		if ($result){
			return true;
		}else{
			return false;
		}
	}
	public function validaUsuario($usuario, $password) {
		$query = "SELECT idUsuario, Nombre, contrasenya FROM usuarios WHERE Nombre=?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("s", $usuario);
		$stmt->execute();
                $result = $stmt->get_result();
		if ($result->num_rows == 1){
                    $fila = $result->fetch_assoc();
                    if (password_verify($password, $fila['contrasenya'])){
                            return $fila;
                    }else{
                            return '0';
                    }
		} else {
                    return '0';
                }
	}
	public function nivelSeguridad($id) {
		$query = "SELECT nivelSeguridad FROM usuarios WHERE idUsuario=?;";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows == 1){
                    $fila = $result->fetch_assoc();
                    return $fila['nivelSeguridad'];
		}
	}
	public function getSeccionesWeb() {
		$query = "SELECT nombreSeccion as Seccion FROM seccionesweb;"; 
                $stmt = $this->db->prepare($query);
                $stmt->execute();
		$result = $stmt->get_result();
                $datos = array();
                while ($fila = $result->fetch_assoc()) {
                    $datos[] = $fila;
                }
                return $datos;
	}

	public function getContenidoWeb($seccion) {
		$query = "SELECT contenidoseccionesweb.idContenido as idContenido, contenidoseccionesweb.idSeccion as idSec, seccionesweb.nombreSeccion as Seccion, titulo, contenido FROM contenidoseccionesweb INNER JOIN seccionesweb on contenidoseccionesweb.idSeccion=seccionesweb.idSeccion where contenidoseccionesweb.idSeccion = ?;"; 
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $seccion);
                $stmt->execute();
		$result = $stmt->get_result();
                $datos = array();
                while ($fila = $result->fetch_assoc()) {
                    $datos[] = $fila;
                }
                return $datos;
	}

	public function putContenidoWeb($array) {
            $query = "DELETE FROM contenidoseccionesweb WHERE idSeccion=?;";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $array[0][1][1]);
            $stmt->execute();
            foreach ($array as $value) {
                $query = "INSERT INTO contenidoseccionesweb (idSeccion, titulo, contenido) VALUES (?, ?, ?);";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("iss", $value[1][1], $value[2][1], $value[3][1]);
                $stmt->execute();
            }
            $this->db->close();
	}

	public function updateContenidoWeb($id, $titulo, $contenido) {
            $query = "UPDATE contenidoseccionesweb SET " . $titulo . "= ? WHERE idContenido = ?;"; 
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $contenido, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->db->close();
            return $result;
	}

        public function getCursos() {
            $query = "SELECT idCurso, nombreCurso, descripcionCurso, inicioCurso, duracionCurso, logoCurso FROM cursos;"; 
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $datos = array();
            while ($fila = $result->fetch_assoc()) {
                $datos[] = $fila;
            }
            return $datos;
	}
        
	public function getCurso($id) {
            $query = "SELECT idCurso, nombreCurso, descripcionCurso, inicioCurso, duracionCurso, logoCurso FROM cursos WHERE idCurso=?;"; 
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $fila = $result->fetch_assoc();
            return $fila;
	}

	public function updateCurso($id, $nombre, $descripcion, $inicio, $duracion, $logo) {
            $query = "UPDATE cursos SET nombreCurso = ?, descripcionCurso = ?, inicioCurso = ?, duracionCurso = ?, logoCurso = ? WHERE idCurso = ?;"; 
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssisi", $nombre, $descripcion, $inicio, $duracion, $logo, $id);
            $result = $stmt->execute();
            $this->db->close();
            return $result;
	}

	public function putCursos($array) {
            $query = "DELETE FROM cursos WHERE true;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            foreach ($array as $value) {
                $query = "INSERT INTO cursos (nombreCurso, descripcionCurso, inicioCurso, duracionCurso, logoCurso) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("sssis", $value[1][1], $value[2][1], $value[3][1], $value[4][1], $value[5][1]);
                $stmt->execute();
            }
            $this->db->commit();
            $this->db->close();
	}

	public function getAlumno($id) {
            $query = "SELECT idUsuario, nivelSeguridad, Nombre, Apellidos, Direccion, CP, Localidad, Provincia, Telefono, email, contrasenya FROM usuarios WHERE idUsuario=?;";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $fila = $result->fetch_assoc();
            $this->db->close();
            return $fila;
	}
	public function getFotoAlumno($id) {    // ******** se necesit la funcion esta ??? ************
            $query = "SELECT fotoAlumno FROM usuarios WHERE idUsuario=?;";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $fila = $result->fetch_assoc();
            $this->db->close();
            return $fila;
	}
	public function putFotoAlumno($id, $foto) {
            $query = "UPDATE usuarios SET fotoAlumno='$foto'  WHERE idUsuario=?;";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
	}
        
	public function getAlumnos() {
		$query = "SELECT idUsuario, nivelSeguridad, Nombre, Apellidos, Direccion, CP, Localidad, Provincia, Telefono, email, contrasenya FROM usuarios;"; 
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $datos = array();
                while ($fila = $result->fetch_assoc()) {
                    $datos[] = $fila;
                }
                return $datos;
	}

        public function updateUsuario($array) {
            $id=$array[1][1];
            $seg=$array[2][1];
            $nom=$array[3][1];
            $ape=$array[4][1];
            $dir=$array[5][1];
            $cp=$array[6][1];
            $loc=$array[7][1];
            $pro=$array[8][1];
            $tel=$array[9][1];
            $ema=$array[10][1];
            $pas=$array[11][1];
            $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, nivelSeguridad = ?, Direccion = ?, cp = ?, Localidad = ?, Provincia = ?, telefono = ?, email = ? WHERE idUsuario = ?;";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssissssssi", $nom, $ape, $seg, $dir, $cp, $loc, $pro, $tel, $ema, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ( $pas !== "" ) {
                $pas=password_hash($pas, PASSWORD_DEFAULT);
                $query = "UPDATE usuarios SET contrasenya='$pas' WHERE idUsuario=?;";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
                }
	}
	public function getCursosAlumno($id) {
		$query = "SELECT cursoscompletados.idCursoRealizado as idCursoHecho, cursoscompletados.idUsuario as IdUser, cursos.idCurso as idCurso, cursos.nombreCurso as nomCurso, cursos.inicioCurso as iniCurso, cursos.duracionCurso as durCurso, cursoscompletados.Comentario as comCurso, cursoscompletados.Nota as notCurso "
                        . " FROM cursoscompletados "
                        . "LEFT JOIN cursos on cursos.idCurso=cursoscompletados.idCurso "
                        . "WHERE idUsuario=?;"; 
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $datos = array();
                while ($fila = $result->fetch_assoc()) {
                    $datos[] = $fila;
                }
                return $datos;
	}
	public function putCursoAlumno($id) {
		$query = "INSERT INTO cursoscompletados (idUsuario) values (?);"; 
		$stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $id);
		$result = $stmt->execute();
	}
	public function updateCursosAlumno($array) {
		$query = "UPDATE cursoscompletados SET idCurso=?, Comentario=?, Nota=?"
                        . " WHERE idCursoRealizado=?;"; 
		$stmt = $this->db->prepare($query);
                $stmt->bind_param("isdi", $idCu, $com, $not, $idCR);
                for ($i=0; $i<count($array); $i++) {
                    $idCu = $array[$i][1];
                    $com = $array[$i][2];
                    $not = $array[$i][3];
                    $idCR = $array[$i][0];
                    $stmt->execute();
                }
	}
        
}
?>