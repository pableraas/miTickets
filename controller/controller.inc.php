<?php

/*
*	Muestra el contenido de la parte central de la página
*	E:
*	S:
*	SQL:
*/
function show_content() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_GET['msg'])) {
        echo "<script>alert('" . htmlspecialchars($_GET['msg']) . "');</script>";
    }
    if (isset($_GET['cmd']) && $_GET['cmd'] === 'cerrarSesion') {
        cerrarSesion();
    }
    if (isset($_GET['cmd']) && $_GET['cmd'] === 'crearIncidencia') {
        $usuario = $_SESSION['usuario'];
        if(comprobarAdmin($usuario)){
            show_header();
            show_menuAdmin("Crear Incidencia");
            show_crearIncidencia(true);
        } else {
            show_header();
            show_menu("Crear Incidencia");
            show_crearIncidencia(false);
        }
    }
    if (isset($_GET['cmd']) && $_GET['cmd'] === 'verIncidencias') {
            show_header();
            show_menuAdmin("Incidencias");
            $incidencias[] = obtenerIncidencias();
            show_verIncidencia($incidencias);
    }
    if (isset($_GET['cmd']) && $_GET['cmd'] === 'estadisticas') {
        show_header();
        show_menuAdmin("Estadísticas");
        $mediaTiempoPrimeraActuacion = calcularMediaTiempoPrimeraActuacion();
        $mediaTiempoCierre = calcularMediaTiempoCierre();
        $reaperturasTotales = calcularReaperturasTotales();
        $promedioReaperturas = calcularMediaReaperturasPorIncidencia();
        $promedioTecnicos[] = calcularMediaPorTecnico();
        $incidenciasUsuarios[] = calcularIncidenciasTotalesUsuario();
        $incidenciasCategoria[] = calcularIncidenciasCategoria();
        $totalIncidencias[] = calcularTotalIncidencias();
        $incidenciasALaPrimera = calcularIncidenciasALaPrimera();
        show_verEstadisticas($mediaTiempoPrimeraActuacion, $mediaTiempoCierre, $reaperturasTotales, 
        $promedioReaperturas, $promedioTecnicos, $incidenciasUsuarios, $incidenciasCategoria, $totalIncidencias, $incidenciasALaPrimera);
    }
    
    if (isset($_GET['cmd']) && $_GET['cmd'] === 'ayuda') {
        $usuario = $_SESSION['usuario'];
        if(comprobarAdmin($usuario)){
            show_header();
            show_menuAdmin("Centro Ayuda");
            show_verAyuda();
        } else {
            show_header();
            show_menu("Centro Ayuda");
            show_verAyuda();
        }
    } else if(isset($_GET['cmd']) && $_GET['cmd'] === 'verAyuda') {
        show_header();
        show_menuAdmin("Centro Ayuda > Ver Incidencias");
        $ayuda[] = obtenerAyudas();
        show_verTablaAyudas($ayuda);
    }

    if (isset($_GET['cmd']) && $_GET['cmd'] === 'perfil')  {
        $idUsuario = $_SESSION['usuario'];
        $usuario[] = buscarUsuario($idUsuario);
        if(comprobarAdmin($idUsuario)){
            show_header();
            show_menuAdmin("Perfil");
            show_verPerfil($usuario[0], true);
            var_dump($usuario);
        } else {
            show_header();
            show_menu("Perfil");
            show_verPerfil($usuario[0], false);       
         }
    } 

    if (isset($_GET['cmd']) && $_GET['cmd'] === 'foro') {
        $usuario = $_SESSION['usuario'];
        if(comprobarAdmin($usuario)){
            show_header();
            show_menuAdmin("Foro");
            $mensajes[] = obtenerMensajesForo();
            show_verForo($mensajes, true);
        } else {
            show_header();
            show_menu("Foro");
            $mensajes[] = obtenerMensajesForo();
            show_verForo($mensajes, false);        }

    } 

    if (isset($_GET['cmd']) && $_GET['cmd'] === 'tablaIncidencias') {
        show_header();
        show_menuAdmin("Administrar BBDD > Tabla Incidencias");
        $incidencias[] = obtenerIncidencias();
        show_tablaIncidenciasBBDD($incidencias);
    } else if(isset($_GET['cmd']) && $_GET['cmd'] === 'tablaDepartamentos') {
        show_header();
        show_menuAdmin("Administrar BBDD > Tabla Departamentos");
        $departamentos[] = obtenerDepartamentos();
        show_tablaDepartamentosBBDD($departamentos);
    } else if(isset($_GET['cmd']) && $_GET['cmd'] === 'tablaUsuarios') {
        show_header();
        show_menuAdmin("Administrar BBDD > Tabla Usuarios");
        $usuarios[] = obtenerUsuarios();
        show_tablaUsuariosBBDD($usuarios);
    } else if(isset($_GET['cmd']) && $_GET['cmd'] === 'tablaAdmin') {
        show_header();
        show_menuAdmin("Administrar BBDD > Tabla Administradores");
        $admins[] = obtenerAdministradores();
        show_tablaAdministradores($admins);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
            $usuario = $_POST['usuario'];
            $contraseña = $_POST['contraseña'];
            // Comprobar en el modelo si el login es correcto
            if (comprobarLogin($usuario, $contraseña)) {
                // Si el login es exitoso, guardar la información en la sesión
                $_SESSION['usuario'] = $usuario;
                if(comprobarAdmin($usuario)){
                    show_menuAdmin("Incidencias");
                    show_header();
                    $incidencias[] = obtenerIncidencias();
                    show_verIncidencia($incidencias);
                } else {
                    show_header();
                    show_menu("Crear Incidencia");
                    show_crearIncidencia(false);
                }
            } else {
                // Si el login falla, mostrar mensaje de error y volver a mostrar login
                echo "<script>alert('Usuario o contraseña incorrectos');</script>";
                show_loging();
            }
        } else if (
            isset($_POST['titulo']) && !empty($_POST['titulo']) &&
            isset($_POST['descripción']) && !empty($_POST['descripción']) &&
            isset($_POST['estado']) && !empty($_POST['estado']) &&
            isset($_POST['prioridad']) && !empty($_POST['prioridad']) &&
            isset($_POST['categoria']) && !empty($_POST['categoria'])) {
            // Recoger los valores del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripción'];
            $estado = $_POST['estado'];
            $prioridad = $_POST['prioridad'];
            $categoria = $_POST['categoria'];
            $fecha = date('Y-m-d H:i:s');
            $usuario = $_SESSION['usuario'];
            $archivo = null;
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
                $archivo = file_get_contents($_FILES['archivo']['tmp_name']); // Almacenar archivo como BLOB
            }
            $resultado = insertarIncidencia($titulo, $descripcion, $estado, $prioridad, $categoria, $archivo, $fecha, $usuario);
            if($resultado)   {
                $emailDestino = obtenerMail($usuario);
                echo "<script>alert('$emailDestino');</script>";
                if($emailDestino)   {
                    mandarMail($emailDestino, $titulo, $descripcion, $estado, $prioridad, $categoria, $fecha, $usuario);
                } else {
                    echo "<script>alert('ERROR: No se pudo obtener el correo electrónico del usuario.');</script>";
                }
            } else {
                echo "<script>alert('No se ha creado la incidencia');</script>";
            }
        } else if(isset($_POST['inputIdIncidencia']) && !empty($_POST['inputIdIncidencia'])) {
            $idIncidencia = $_POST['inputIdIncidencia'];
            if(comprobarIDIncidencia($idIncidencia))    {
                show_header();
                show_menuAdmin("> Administrar BBDD > Tabla Incidencias > ID_Incidencia: $idIncidencia");
                $incidencia[] = buscarIncidencia($idIncidencia);
                var_dump($incidencia);
                show_crudIncidencias($incidencia[0]);
            } else {
                echo "<script>alert('No se encontró ninguna incidencia con ese ID');</script>";
                $incidencias[] = obtenerIncidencias();
                show_header();
                show_menuAdmin("> Administrar BBDD > Tabla Incidencias");
                show_tablaIncidenciasBBDD($incidencias);
            }
        } else if(isset($_POST['inputIdDepartamento']) && !empty($_POST['inputIdDepartamento'])) {
            $idDepartamento = $_POST['inputIdDepartamento'];
            if(comprobarIDDepartamento($idDepartamento))    {
                show_header();
                show_menuAdmin("> Administrar BBDD > Tabla Departamentos > ID_Departamento: $idDepartamento");
                $departamento[] = buscarDepartamento($idDepartamento);
                var_dump($departamento);
                show_crudDepartamentos($departamento[0]);
            } else {
                echo "<script>alert('No se encontró ningún departamento con ese ID');</script>";
                show_header();
                show_menuAdmin("Administrar BBDD > Tabla Departamentos");
                $departamentos[] = obtenerDepartamentos();
                show_tablaDepartamentosBBDD($departamentos);
            }
        } else if(isset($_POST['inputIdUsuario']) && !empty($_POST['inputIdUsuario'])) {
            $idUsuario = $_POST['inputIdUsuario'];
            if(comprobarIDUsuario($idUsuario))    {
                show_header();
                show_menuAdmin("> Administrar BBDD > Tabla Usuarios > ID_Usuario: $idUsuario");
                $usuario[] = buscarUsuario($idUsuario);
                var_dump($idUsuario);
                show_crudUsuarios($usuario[0]);
            } else {
                echo "<script>alert('No se encontró ningún Usuario con ese ID');</script>";
                show_header();
                show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                $usuarios[] = obtenerUsuarios();
                show_tablaUsuariosBBDD($usuarios);
            }
        } else if(isset($_POST['inputIDAdmin']) && !empty($_POST['inputIDAdmin'])) {
            $idAdmin = $_POST['inputIDAdmin'];
            if(comprobarIDAdmin($idAdmin))    {
                show_header();
                show_menuAdmin("> Administrar BBDD > Tabla Admin > ID_Admin: $idAdmin");
                $admin[] = buscarAdmin($idAdmin);
                var_dump($idAdmin);
                show_crudAdmin($admin[0]);
            } else {
                echo "<script>alert('No se encontró ningún Admin con ese ID');</script>";
                show_header();
                show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                $usuarios[] = obtenerUsuarios();
                show_tablaUsuariosBBDD($usuarios);
            }
        } else if(isset($_POST['textAreaMsj']) && !empty($_POST['textAreaMsj'])) {
            $mensaje = $_POST['textAreaMsj'];
            $usuario = $_SESSION['usuario'];
            $fecha = date('Y-m-d H:i:s');
            insertarMensajeForo($usuario, $mensaje, $fecha);
            if(comprobarAdmin($usuario)){
                show_header();
                show_menuAdmin("Foro");
                $mensajes[] = obtenerMensajesForo();
                show_verForo($mensajes, true);
            } else {
                show_header();
                show_menu("Foro");
                $mensajes[] = obtenerMensajesForo();
                show_verForo($mensajes, false);        
            }
        } else if(isset($_POST['borrarMensaje']) && !empty($_POST['idMensaje'])) {
            $idMensaje = $_POST['idMensaje'];
            eliminarMensajeForo($idMensaje);
            echo "<script type='text/javascript'>alert('Mensaje Borrado');</script>";
            show_header();
            show_menuAdmin("Foro");
            $mensajes[] = obtenerMensajesForo();
            show_verForo($mensajes, true);
        } else  if (isset($_POST['accion'])) {
            $accion = $_POST['accion'];
            switch ($accion) {
                case 'eliminarIncidencia':
                    if (isset($_POST['idIncidencia'])) {
                        $idIncidencia = $_POST['idIncidencia'];
                        $resultado = eliminarIncidencia($idIncidencia);
                        if ($resultado) {
                            // Redirigir o mostrar mensaje de éxito
                            echo "<script type='text/javascript'>alert('Incidencia eliminada...');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Incidencias");
                            $incidencias[] = obtenerIncidencias();
                            show_tablaIncidenciasBBDD($incidencias);
                        } else {
                            // Manejo de errores
                            echo "<script type='text/javascript'>alert('ERROR...No se ha eliminado la incidencia');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Incidencias");
                            $incidencias[] = obtenerIncidencias();
                            show_tablaIncidenciasBBDD($incidencias);
                        }
                    }
                    break;
                case 'actualizarIncidencia':
                    if (isset($_POST['idIncidencia'])) {
                        $idIncidencia = $_POST['idIncidencia'];
                        $titulo = $_POST['titulo'];
                        $descripcion = $_POST['descripcion'];
                        $idUsuario = $_POST['idUsuario'];
                        $idTecnico = $_POST['idTecnico'];
                        $estado = $_POST['Estado'];
                        $prioridad = $_POST['prioridad'];
                        $categoria = $_POST['categoria'];
                        $fecha = $_POST['fecha'];
                        $archivo = $_POST['archivo'];
                        $resultado = actualizarIncidencia($idIncidencia, $titulo, $descripcion, $idUsuario, $idTecnico, $estado, $prioridad, $categoria, $fecha, $archivo);
                        if ($resultado) {
                            // Redirigir o mostrar mensaje de éxito
                            echo "<script type='text/javascript'>alert('Incidencia modificada con éxito');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Incidencias");
                            $incidencias[] = obtenerIncidencias();
                            show_tablaIncidenciasBBDD($incidencias);
                        } else {
                            // Manejo de errores
                            echo "<script type='text/javascript'>alert('ERROR...No se ha modificado la incidencia');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Incidencias");
                            $incidencias[] = obtenerIncidencias();
                            show_tablaIncidenciasBBDD($incidencias);
                        }
                    }
                    break;
                case 'eliminarDepartamento':
                    if (isset($_POST['idDepartamento'])) {
                        $idDepartamento = $_POST['idDepartamento'];
                        $resultado = eliminarDepartamento($idDepartamento);
                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Departamento eliminado...');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Departamentos");
                            $departamentos[] = obtenerDepartamentos();
                            show_tablaDepartamentosBBDD($departamentos);
                        } else {
                            echo "<script type='text/javascript'>alert('ERROR...No se ha eliminado el departamento');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Departamentos");
                            $departamentos[] = obtenerDepartamentos();
                            show_tablaDepartamentosBBDD($departamentos);
                        }
                    }
                    break;    
                case 'actualizarDepartamento':
                    if (isset($_POST['idDepartamento'])) {
                        $idDepartamento = $_POST['idDepartamento'];
                        $nombre = $_POST['nombre'];
                        $telefono = $_POST['telefono'];
                        $email = $_POST['email'];
                        $resultado = actualizarDepartamento($idDepartamento, $nombre, $telefono, $email);
                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Departamento modificado con éxito');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Departamentos");
                            $departamentos[] = obtenerDepartamentos();
                            show_tablaDepartamentosBBDD($departamentos);
                        } else {
                            // Manejo de errores
                            echo "<script type='text/javascript'>alert('ERROR...No se ha modificado el departamento');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Departamentos");
                            $departamentos[] = obtenerDepartamentos();
                            show_tablaDepartamentosBBDD($departamentos);
                        }
                    }
                    break;
                case 'eliminarUsuario':
                    if (isset($_POST['idUsuario'])) {
                        $idUsuario = $_POST['idUsuario'];
                        $resultado = eliminarUsuario($idUsuario);
                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Usuario eliminado...');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                            $usuarios[] = obtenerUsuarios();
                            show_tablaUsuariosBBDD($usuarios);
                        } else {
                            echo "<script type='text/javascript'>alert('ERROR...No se ha eliminado el usuario');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                            $usuarios[] = obtenerUsuarios();
                            show_tablaUsuariosBBDD($usuarios);
                        }
                    }
                    break;    
                case 'actualizarUsuario':
                    if (isset($_POST['idUsuario'])) {
                        $idUsuario = $_POST['idUsuario'];
                        $nombre = $_POST['nombre'];
                        $apellido = $_POST['apellido'];
                        $idDepartamento = $_POST['idDepartamento'];
                        $contraseña = $_POST['contraseña'];
                        $email = $_POST['email'];
                        $resultado = actualizarUsuario($idUsuario, $nombre, $apellido,$idDepartamento,$contraseña, $email);
                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Usuario modificado con éxito');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                            $usuarios[] = obtenerUsuarios();
                            show_tablaUsuariosBBDD($usuarios);
                        } else {
                            // Manejo de errores
                            echo "<script type='text/javascript'>alert('ERROR...No se ha modificado el usuario');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Usuarios");
                            $usuarios[] = obtenerUsuarios();
                            show_tablaUsuariosBBDD($usuarios);
                        }
                    }
                    break;
                case 'eliminarAdmin':
                    if (isset($_POST['idAdmin'])) {
                        $idAdmin = $_POST['idAdmin'];
                        $resultado = eliminarAdmin($idAdmin);

                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Admin eliminado...');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Administradores");
                            $admins[] = obtenerAdministradores();
                            show_tablaAdministradores($admins);
                        } else {
                            echo "<script type='text/javascript'>alert('ERROR...No se ha eliminado el admin');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Administradores");
                            $admins[] = obtenerAdministradores();
                            show_tablaAdministradores($admins);
                        }
                    }
                    break;    
                case 'actualizarAdmin':
                    if (isset($_POST['idAdmin'])) {
                        $idAdmin = $_POST['idAdmin'];
                        $rol = $_POST['rol'];
                        $resultado = actualizarAdmin($idAdmin, $rol);
                        if ($resultado) {
                            echo "<script type='text/javascript'>alert('Admin modificado con éxito');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Administradores");
                            $admins[] = obtenerAdministradores();
                            show_tablaAdministradores($admins);
                        } else {
                            // Manejo de errores
                            echo "<script type='text/javascript'>alert('ERROR...No se ha modificado el admin');</script>";
                            show_header();
                            show_menuAdmin("Administrar BBDD > Tabla Administradores");
                            $admins[] = obtenerAdministradores();
                            show_tablaAdministradores($admins);
                        }
                    }
                    break;
                
                    default:
                    echo "Acción no reconocida.";
                    break;
            }

        } else if (isset($_POST['titulo']) && !empty($_POST['titulo']) && isset($_POST['descripción']) && !empty($_POST['descripción'])) {
            $idUsuario = $_SESSION['usuario'];
            $fecha = date('Y-m-d H:i:s');
            $descripcion = $_POST['descripción'];
            $titulo = $_POST['titulo'];
            echo "<script>alert('Incidencia Creada...');</script>";
            $emailDestino = obtenerMail($idUsuario);
            if(comprobarAdmin($idUsuario)){
                show_header();
                show_menuAdmin("Centro Ayuda");
                show_verAyuda();
            } else {
                show_header();
                show_menu("Centro Ayuda");
                show_verAyuda();
            } 
            insertarAyuda($idUsuario, $titulo, $descripcion, $fecha);
            mandarMailAyuda($emailDestino, $titulo, $descripcion, $fecha);
 
        } else {
            echo "<script>alert('No se han enviado correctamente los datos');</script>";
            $usuario = $_SESSION['usuario'];
            if(comprobarAdmin($usuario)){
                show_header();
                show_menuAdmin("Crear Incidencia");
                show_crearIncidencia(true);
            } else {
                show_header();
                show_menu("Crear Incidencia");
                show_crearIncidencia(false);
            }
        }
    } else {
        show_loging();
    }
}
?>

