<?php

require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';
require 'phpMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

function comprobarLogin($usuario, $contraseña)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM Usuarios WHERE idUsuario = '$usuario' AND Contraseña = '$contraseña'";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarAdmin($usuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM UsuariosAdmin WHERE idUsuario = '$usuario'";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function cerrarSesion()	{
	session_destroy();
    header("Location: index.php?msg=Sesión cerrada");
    exit();
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function insertarIncidencia($titulo, $descripcion, $estado, $prioridad, $categoria, $archivo, $fecha, $usuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "INSERT INTO Incidencias (idUsuario, Estado, Prioridad, Categoria, Titulo, Descripcion, FechaApertura, Archivo) 
		VALUES ('$usuario', '$estado', '$prioridad', '$categoria', '$titulo', '$descripcion', '$fecha', '$archivo');";		
		if(mysqli_query($conexion, $query) == true)    {
			//header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito");
			echo "<script type='text/javascript'>alert('Incidencia creada con éxito');</script>";
			mysqli_close($conexion);
			return true;
		} else {
			return false;
		}
	}else{
		return false;
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerIncidencias()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$incidencias = [];
	if($conexion)	{
		$query = "SELECT * FROM Incidencias;";		
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$incidencias[] = $row;
			// Imprimir cada fila para ver qué se está añadiendo
			//echo "<pre>" . print_r($row, true) . "</pre>";
			}		
		}
	mysqli_close($conexion); // Cierra la conexión
	return $incidencias; // Devuelve el array de incidencias
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerDepartamentos()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$departamentos = [];
	if($conexion)	{
		$query = "SELECT * FROM Departamentos;";		
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$departamentos[] = $row;
			// Imprimir cada fila para ver qué se está añadiendo
			//echo "<pre>" . print_r($row, true) . "</pre>";
			}		
		}
	mysqli_close($conexion); // Cierra la conexión
	return $departamentos; // Devuelve el array de departamentos
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerUsuarios()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$usuarios = [];
	if($conexion)	{
		$query = "SELECT * FROM Usuarios;";		
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$usuarios[] = $row;
			}		
		}
	mysqli_close($conexion); // Cierra la conexión
	return $usuarios;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerAdministradores()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$admin = [];
	if($conexion)	{
		$query = "SELECT * FROM Usuariosadmin;";		
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$admin[] = $row;
			}		
		}
	mysqli_close($conexion); // Cierra la conexión
	return $admin;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerMail($usuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT Email FROM Usuarios WHERE idUsuario = '$usuario';";
		$resultado = mysqli_query($conexion, $query);		
		if($resultado && mysqli_num_rows($resultado) > 0) {
			$fila = mysqli_fetch_assoc($resultado);
			$email = $fila['Email'];
			// Cerramos la conexión antes de retornar
			mysqli_close($conexion);
			return $email;
		}else{
			echo "<script type='text/javascript'>alert('ERROR...No se ha podido obtener el mail');</script>";
			return null;
		}
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function mandarMail($emailDestino, $titulo, $descripcion, $estado, $prioridad, $categoria, $fecha)	{
	$mail = new PHPMailer();
	try{
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = "sellinggoodscontact@gmail.com";
		$mail->Password = 'wynohhyqcyymsjry';
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;

		$mail->setFrom('sellinggoodscontact@gmail.com', 'miTickets');
		$mail->addAddress("$emailDestino");

		$mail->isHTML(true);
		$mail->Subject = 'Nueva Incidencia Creada';
		$mail->Body = "<h2> Has creado una nueva incidencia </h2>" . 
					  "<h3>Estado: </h3>" . $estado	.
					  "<h3>Prioridad: </h3>" . $prioridad	.
					  "<h3>Categoría:</h3>" . $categoria	.
					  "<h3>Título: </h3>" . $titulo	.
					  "<h3>Descripción: </h3>" . $descripcion	.
					  "<h3>Fecha de creación: </h3>" . $fecha;


		$mail->send();
		header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito, se ha enviado un correo.");
		exit();
	} catch (Exception $e)	{
		echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}"; // Muestra el error
        header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito, no se ha enviado un correo.");
        exit();
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function buscarIncidencia($idIncidencia)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$incidencia = [];
	if($conexion)	{
		$query = "SELECT * FROM Incidencias WHERE idIncidencia = $idIncidencia;";		
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			while($row = mysqli_fetch_assoc($resultado))	{
			$incidencia[] = $row;
			}	
		}
	mysqli_close($conexion); // Cierra la conexión
	return $incidencia;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function buscarDepartamento($idDepartamento)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$departamento = [];
	if($conexion)	{
		$query = "SELECT * FROM Departamentos WHERE idDepartamento = $idDepartamento;";		
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			while($row = mysqli_fetch_assoc($resultado))	{
			$departamento[] = $row;
			}	
		}
	mysqli_close($conexion); // Cierra la conexión
	return $departamento;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function buscarUsuario($idUsuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$usuario = [];
	if($conexion)	{
		$query = "SELECT * FROM Usuarios WHERE idUsuario = $idUsuario;";		
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			while($row = mysqli_fetch_assoc($resultado))	{
			$usuario[] = $row;
			}	
		}
	mysqli_close($conexion); // Cierra la conexión
	return $usuario;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function buscarAdmin($idUsuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$usuario = [];
	if($conexion)	{
		$query = "SELECT * FROM Usuariosadmin WHERE idUsuario = $idUsuario;";		
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			while($row = mysqli_fetch_assoc($resultado))	{
			$usuario[] = $row;
			}	
		}
	mysqli_close($conexion); // Cierra la conexión
	return $usuario;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarIDIncidencia($idIncidencia)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM Incidencias WHERE idIncidencia = $idIncidencia";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarIDDepartamento($idDepartamento)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM Departamentos WHERE idDepartamento = $idDepartamento";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarIDUsuario($idUsuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM Usuarios WHERE idUsuario = $idUsuario";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarIDAdmin($idUsuario)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT * FROM Usuariosadmin WHERE idUsuario = $idUsuario";
		$resultado = mysqli_query($conexion, $query);
		if(mysqli_num_rows($resultado) != 0)  {
			return true;
		} else {
			return false;
		}
		mysqli_close($conexion);
	}else{
		echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function eliminarIncidencia($idIncidencia) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);    
    if ($conexion) {
        $idIncidencia = (int)$idIncidencia;
        $query = "DELETE FROM incidencias WHERE idIncidencia = $idIncidencia";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function actualizarIncidencia($idIncidencia, $titulo, $descripcion, $idUsuario, $idTecnico, $estado, $prioridad, $categoria, $fecha) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);

    if ($conexion) {
        $idIncidencia = (int)$idIncidencia;
        $titulo = mysqli_real_escape_string($conexion, $titulo);
        $descripcion = mysqli_real_escape_string($conexion, $descripcion);
        $idUsuario = (int)$idUsuario;
        $idTecnico = (int)$idTecnico;
        $estado = mysqli_real_escape_string($conexion, $estado);
        $prioridad = mysqli_real_escape_string($conexion, $prioridad);
        $categoria = mysqli_real_escape_string($conexion, $categoria);
        $fecha = mysqli_real_escape_string($conexion, $fecha);
        $query = "UPDATE incidencias SET 
                    Titulo = '$titulo', 
                    Descripcion = '$descripcion', 
                    idUsuario = $idUsuario, 
                    idTecnico = $idTecnico, 
                    Estado = '$estado', 
                    Prioridad = '$prioridad', 
                    Categoria = '$categoria', 
                    FechaApertura = '$fecha' 
                  WHERE idIncidencia = $idIncidencia";

		$resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function eliminarDepartamento($idDepartamento) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);    
    if ($conexion) {
        $idDepartamento = (int)$idDepartamento;
        $query = "DELETE FROM departamentos WHERE idDepartamento = $idDepartamento";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function actualizarDepartamento($idDepartamento, $nombre, $telefono, $email) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);

    if ($conexion) {
        $idDepartamento = (int)$idDepartamento;
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $telefono = mysqli_real_escape_string($conexion, $telefono);
        $email = mysqli_real_escape_string($conexion, $email);
        $query = "UPDATE departamentos SET 
                    Nombre = '$nombre', 
                    Telefono = '$telefono', 
                    Email = '$email'
                  WHERE idDepartamento = $idDepartamento";
		$resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function eliminarUsuario($idUsuario) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);    
    if ($conexion) {
        $idUsuario = (int)$idUsuario;
        $query = "DELETE FROM usuarios WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function actualizarUsuario($idUsuario, $nombre, $apellido,$idDepartamento,$contraseña, $email) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);

    if ($conexion) {
		$idUsuario = (int)$idUsuario;

        $idDepartamento = (int)$idDepartamento;
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $apellido = mysqli_real_escape_string($conexion, $apellido);
		$contraseña = mysqli_real_escape_string($conexion, $contraseña);
        $email = mysqli_real_escape_string($conexion, $email);
        $query = "UPDATE usuarios SET 
                    Nombre = '$nombre', 
					Apellido1 = '$apellido', 
					Contraseña = '$contraseña',
                    idDepartamento = '$idDepartamento', 
                    Email = '$email'
                  WHERE idUsuario = $idUsuario";
		$resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function eliminarAdmin($idUsuario) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);    
    if ($conexion) {
        $idUsuario = (int)$idUsuario;
        $query = "DELETE FROM usuariosadmin WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function actualizarAdmin($idAdmin, $rol) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);

    if ($conexion) {
		$idAdmin = (int)$idAdmin;
        $rol = mysqli_real_escape_string($conexion, $rol);

        $query = "UPDATE usuariosadmin SET 
                    Rol = '$rol'
                  WHERE idUsuario = $idAdmin";
		$resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerTiemposPrimeraActuacion()	{
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
			SELECT 
				i.idIncidencia,
				TIMESTAMPDIFF(DAY, i.FechaApertura, MIN(h.FechaActuacion)) AS Dias,
				MOD(TIMESTAMPDIFF(HOUR, i.FechaApertura, MIN(h.FechaActuacion)), 24) AS Horas,
				MOD(TIMESTAMPDIFF(MINUTE, i.FechaApertura, MIN(h.FechaActuacion)), 60) AS Minutos
			FROM 
				incidencias i
			JOIN 
				historialactuaciones h ON i.idIncidencia = h.idIncidencia
			GROUP BY 
				i.idIncidencia
		";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "Incidencia ID: " . $row["idIncidencia"] . " - ";
				echo "Días: " . $row["Dias"] . ", ";
				echo "Horas: " . $row["Horas"] . ", ";
				echo "Minutos: " . $row["Minutos"] . "<br>";
			}
		} else {
			echo "No se encontraron resultados.";
		}
	$conn->close();
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularMediaTiempoPrimeraActuacion()	{
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
			SELECT CONCAT( 
				FLOOR(AVG(TiempoPrimeraActuacion) / (24 * 60)), ' días, ', -- Días 
				FLOOR((AVG(TiempoPrimeraActuacion) % (24 * 60)) / 60), ' horas, ', -- Horas 
				FLOOR(AVG(TiempoPrimeraActuacion) % 60), ' minutos' -- Minutos 
			) AS MediaTiempoPrimeraActuación 
			FROM ( 
				SELECT TIMESTAMPDIFF(MINUTE, i.FechaApertura, MIN(h.FechaActuacion)) AS TiempoPrimeraActuacion 
				FROM incidencias i 
				JOIN historialactuaciones h ON i.idIncidencia = h.idIncidencia 
				GROUP BY i.idIncidencia 
			) AS Tiempos;

		";
		$result = mysqli_query($conexion, $sql);
        if ($result) {
            $fila = mysqli_fetch_assoc($result);
            return $fila['MediaTiempoPrimeraActuación'];
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    } else {
        echo "Error de conexión: " . mysqli_connect_error();
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularMediaTiempoCierre() {
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
			SELECT CONCAT(
				FLOOR(AVG(TiempoCierre) / (24 * 60)), ' días, ', -- Días
				FLOOR((AVG(TiempoCierre) % (24 * 60)) / 60), ' horas, ', -- Horas
				FLOOR(AVG(TiempoCierre) % 60), ' minutos' -- Minutos
			) AS TiempoPromedioCierre
			FROM (
				SELECT TIMESTAMPDIFF(MINUTE, FechaApertura, FechaCierre) AS TiempoCierre
				FROM incidencias
				WHERE FechaCierre IS NOT NULL -- Solo consideramos incidencias cerradas
			) AS Tiempos;
		";
		$result = mysqli_query($conexion, $sql);
        if ($result) {
            $fila = mysqli_fetch_assoc($result);
            return $fila['TiempoPromedioCierre'];
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    } else {
        echo "Error de conexión: " . mysqli_connect_error();
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularReaperturasTotales()	{
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
		SELECT 
			CONCAT(
				COUNT(*), ' (', ROUND((COUNT(*) / (SELECT COUNT(*) FROM historialactuaciones)) * 100, 2), ' %)'
			) AS TotalReaperturas
		FROM 
			historialactuaciones
		WHERE 
			Descripcion = 'Reapertura';
		";
		$result = mysqli_query($conexion, $sql);
        if ($result) {
            $fila = mysqli_fetch_assoc($result);
            return $fila['TotalReaperturas'];
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    } else {
        echo "Error de conexión: " . mysqli_connect_error();
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularMediaReaperturasPorIncidencia()	{
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
			SELECT AVG(CantidadReaperturas) AS PromedioReaperturas 
			FROM (
			SELECT idIncidencia, COUNT(*) AS CantidadReaperturas 
			FROM historialactuaciones 
			WHERE Descripcion = 'Reapertura' 
			GROUP BY idIncidencia
			) AS MediaReaperturasIncidencia;
		";
		$result = mysqli_query($conexion, $sql);
        if ($result) {
            $fila = mysqli_fetch_assoc($result);
            return $fila['PromedioReaperturas'];
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    } else {
        echo "Error de conexión: " . mysqli_connect_error();
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularMediaPorTecnico()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$tecnicos = [];
	if($conexion)	{
		$query = "
			SELECT 
				h.idTecnico,
				CONCAT(
					COUNT(*), ' (', ROUND((COUNT(*) / (SELECT COUNT(*) FROM incidencias)) * 100, 2), ' %)'
				) AS IncidenciasTotales,
				CONCAT(
					FLOOR(AVG(TIMESTAMPDIFF(MINUTE, i.FechaApertura, h.FechaActuacion)) / (24 * 60)), ' días, ',
					FLOOR((AVG(TIMESTAMPDIFF(MINUTE, i.FechaApertura, h.FechaActuacion)) % (24 * 60)) / 60), ' horas, ',
					ROUND(AVG(TIMESTAMPDIFF(MINUTE, i.FechaApertura, h.FechaActuacion)) % 60), ' minutos'
				) AS TiempoPromedioResolucion
			FROM 
				incidencias i
			JOIN 
				historialactuaciones h ON i.idIncidencia = h.idIncidencia
			GROUP BY 
				h.idTecnico;

		";
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$tecnicos[] = $row;
			}		
		}
	mysqli_close($conexion);
	return $tecnicos; 
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularIncidenciasTotalesUsuario()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$usuarios = [];
	if($conexion)	{
		$query = "
			SELECT 
				i.idUsuario, 
				CONCAT(u.Nombre, ' ', u.Apellido1) AS Nombre, 
				CONCAT(
					COUNT(*), ' (', ROUND((COUNT(*) / (SELECT COUNT(*) FROM incidencias)) * 100, 2), ' %)'
				) AS IncidenciasTotales
			FROM 
				incidencias i
			JOIN 
				usuarios u ON i.idUsuario = u.idUsuario
			GROUP BY 
				i.idUsuario, u.Nombre, u.Apellido1;
		";
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$usuarios[] = $row;
			}		
		}
	mysqli_close($conexion);
	return $usuarios; 
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularIncidenciasCategoria()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$categorias = [];
	if($conexion)	{
		$query = "
			SELECT i.Categoria, 
    		CONCAT(COUNT(*), ' (', ROUND((COUNT(*) / (SELECT COUNT(*) FROM incidencias)) * 100, 2), ' %)') AS IncidenciasYPorcentaje
			FROM 
				incidencias i
			GROUP BY 
				i.Categoria;
		";
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$categorias[] = $row;
			}		
		}
	mysqli_close($conexion);
	return $categorias; 
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularTotalIncidencias()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$incidencias = [];
	if($conexion)	{
		$query = "
			SELECT 
    CONCAT(COUNT(CASE WHEN i.Estado = 'Abierta' THEN 1 END), ' (', 
           ROUND((COUNT(CASE WHEN i.Estado = 'Abierta' THEN 1 END) / COUNT(*)) * 100, 2), 
           '%)') AS TotalAbiertas,
    CONCAT(COUNT(CASE WHEN i.Estado = 'Cerrada' THEN 1 END), ' (', 
           ROUND((COUNT(CASE WHEN i.Estado = 'Cerrada' THEN 1 END) / COUNT(*)) * 100, 2), 
           '%)') AS TotalCerradas,
    CONCAT(COUNT(CASE WHEN i.Estado = 'En Proceso' THEN 1 END), ' (', 
           ROUND((COUNT(CASE WHEN i.Estado = 'En Progreso' THEN 1 END) / COUNT(*)) * 100, 2), 
           '%)') AS TotalEnProceso,
    COUNT(*) AS TotalIncidencias -- Total de todas las incidencias
	FROM 
    incidencias i;

		";
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$incidencias[] = $row;
			}		
		}
	mysqli_close($conexion);
	return $incidencias; 
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function calcularIncidenciasALaPrimera()	{
	include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
    if ($conexion) {
		$sql = "
		SELECT 
			CONCAT(
				COUNT(DISTINCT i.idIncidencia), 
				' (', 
				ROUND(COUNT(DISTINCT i.idIncidencia) * 100 / (SELECT COUNT(*) FROM incidencias), 2), 
				'%)'
			) AS IncidenciasResueltasPrimerIntento
		FROM 
			incidencias i
		LEFT JOIN 
			historialactuaciones h 
			ON i.idIncidencia = h.idIncidencia 
			AND h.Descripcion = 'Reapertura'
		WHERE 
			h.idIncidencia IS NULL;  -- Incidencias que no tienen reaperturas
		";
		$result = mysqli_query($conexion, $sql);
        if ($result) {
            $fila = mysqli_fetch_assoc($result);
            return $fila['IncidenciasResueltasPrimerIntento'];
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    } else {
        echo "Error de conexión: " . mysqli_connect_error();
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerMensajesForo()	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	$mensajes = [];
	if($conexion)	{
		$query = "SELECT * FROM ForoMensajes ORDER BY Fecha ASC;";		
		$result = mysqli_query($conexion, $query);
		if($result)	{
			while($row = mysqli_fetch_assoc($result))	{
			$mensajes[] = $row;
			}		
		}
	mysqli_close($conexion); // Cierra la conexión
	return $mensajes; // Devuelve el array de incidencias
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerNombreUsuario($usuario) {
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "SELECT Nombre, Apellido1 FROM Usuarios WHERE idUsuario = '$usuario';";
		$resultado = mysqli_query($conexion, $query);		
		if($resultado && mysqli_num_rows($resultado) > 0) {
			$fila = mysqli_fetch_assoc($resultado);
			$nombreCompleto = $fila['Nombre'] . ' ' . $fila['Apellido1'];
			mysqli_close($conexion);
			return $nombreCompleto;
		}else{
			echo "<script type='text/javascript'>alert('ERROR...No se ha podido obtener el nombre');</script>";
			return null;
		}
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function insertarMensajeForo($usuario, $mensaje, $fecha) {
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "INSERT INTO ForoMensajes (idUsuario, Mensaje, Fecha) 
		VALUES ('$usuario', '$mensaje','$fecha');";		
		if(mysqli_query($conexion, $query) == true)    {
			//header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito");
			mysqli_close($conexion);
			return true;
		} else {
			return false;
		}
	}else{
		return false;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function eliminarMensajeForo($idMensaje) {
    include __DIR__ . '/../configuration.inc.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);    
    if ($conexion) {
        $idMensaje = (int)$idMensaje;
        $query = "DELETE FROM ForoMensajes WHERE idMensaje = $idMensaje";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            return mysqli_affected_rows($conexion) > 0;
        } else {
			echo "<script type='text/javascript'>alert('ERROR...Consulta fallida');</script>";
            return false;
        }
        mysqli_close($conexion);
    } else {
        echo "<script type='text/javascript'>alert('ERROR...Conexión fallida con la BBDD');</script>";
        return false;
    }
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function insertarAyuda($idUsuario, $titulo, $descripcion, $fecha)	{
	include __DIR__ . '/../configuration.inc.php';
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
	if($conexion){
		$query = "INSERT INTO Ayuda (idUsuario, Titulo, Descripcion, Fecha) 
		VALUES ('$idUsuario', '$titulo',  '$descripcion','$fecha');";		
		if(mysqli_query($conexion, $query) == true)    {
			//header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito");
			mysqli_close($conexion);
			return true;
		} else {
			return false;
		}
	}else{
		return false;
	}
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function obtenerAyudas()	{
		include __DIR__ . '/../configuration.inc.php';
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$conexion = mysqli_connect($servidor, $usuarioBBDD, $password, $basedatos);
		$departamentos = [];
		if($conexion)	{
			$query = "SELECT * FROM Ayuda;";		
			$result = mysqli_query($conexion, $query);
			if($result)	{
				while($row = mysqli_fetch_assoc($result))	{
				$ayuda[] = $row;
				// Imprimir cada fila para ver qué se está añadiendo
				//echo "<pre>" . print_r($row, true) . "</pre>";
				}		
			}
		mysqli_close($conexion); // Cierra la conexión
		return $ayuda; // Devuelve el array de departamentos
		}
	}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function mandarMailAyuda($emailDestino, $titulo, $descripcion, $fecha)	{
	$mail = new PHPMailer();
	try{
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = "sellinggoodscontact@gmail.com";
		$mail->Password = 'wynohhyqcyymsjry';
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;

		$mail->setFrom('sellinggoodscontact@gmail.com', 'miTickets');
		$mail->addAddress("$emailDestino");

		$mail->isHTML(true);
		$mail->Subject = 'Nueva Incidencia Creada';
		$mail->Body = "<h2> Has creado un ticket de incidencia </h2>" . 
					  "<h3>Título: </h3>" . $titulo	.
					  "<h3>Descripción: </h3>" . $descripcion	.
					  "<h3>Fecha de creación: </h3>" . $fecha;


		$mail->send();
		exit();
	} catch (Exception $e)	{
        header("Location: index.php?cmd=crearIncidencia&msg=Incidencia creada con éxito, no se ha enviado un correo.");
        exit();
	}
}