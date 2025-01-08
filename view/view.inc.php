<?php

function show_header(){
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>MiTickets</title>
        <link rel="stylesheet" type="text/css" href="view/style.css"> 

    </head>
    <body>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_menu($estado) {
	//if (isset($_SESSION['user'])) {
		echo '
        <header class="main-header">
            <h1 id="txtMain">MiTickets  > ' . htmlspecialchars($estado) . '</h1>
            <img src="images/logoFinal.png" alt="Logo" class="headerImg">   
            <a href="index.php?cmd=perfil">
                <img src="images/imgPerfil.png" class="imgPerfil">
            </a>      
            <nav class="navBarraTareas">
                    <ul class="navigation">
                    <li><a href="index.php?cmd=crearIncidencia">Crear incidencia</a></li>
                    <li><a href="index.php?cmd=foro">Foro</a></li>
                    <li><a href="index.php?cmd=ayuda">Centro Ayuda</a></li>
                    <li><a href="index.php?cmd=cerrarSesion">Cerrar sesión</a></li>
                </ul>
            </nav>   
        </header>   ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_menuAdmin($estado) {
		echo '
        <header class="main-header">
            <h1 id="txtMain">MiTickets  > ' . htmlspecialchars($estado) . '</h1>
            <img src="images/logoFinal.png" alt="Logo" class="headerImg">  
            <a href="index.php?cmd=perfil">
                <img src="images/imgPerfil.png" class="imgPerfil">
            </a>
            <nav class="navBarraTareas">
                    <ul class="navigation">
                    <li><a href="index.php?cmd=verIncidencias">Incidencias</a></li>
                    <li><a href="index.php?cmd=crearIncidencia">Crear incidencia</a></li>
                    <li><a href="index.php?cmd=foro">Foro</a></li>
                    <li class="oculto">
                    <a href="#" class="disabled-link">Administrar BBDD</a>
                    <ul class="contenido-oculto">
                        <li><a href="index.php?cmd=tablaIncidencias">Tabla Incidencias</a></li>
                        <li><a href="index.php?cmd=tablaDepartamentos">Tabla Departamentos</a></li>
                        <li><a href="index.php?cmd=tablaUsuarios">Tabla Usuarios</a></li>
                        <li><a href="index.php?cmd=tablaAdmin">Tabla Usuarios-Admin</a></li>
                    </ul>
                    </li>
                    <li><a href="index.php?cmd=estadisticas">Estadísticas</a></li>
                    <li class="oculto">
                    <a href="#" class="disabled-link">Centro Ayuda</a>
                    <ul class="contenido-oculto">
                        <li><a href="index.php?cmd=ayuda">Crear Incidencia</a></li>
                        <li><a href="index.php?cmd=verAyuda">Ver Incidencias</a></li>
                    </ul>
                    </li>
                   <li><a href="index.php?cmd=cerrarSesion">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>   ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_loging() {
	echo '
    <body>
      <div class="login">                
        <div class="mainLogin">
                <h1 id="txtLogin">MiTickets</h1>
                <h3>Introduce las credenciales</h3>
                <form action="index.php" method="POST">
                    <label class="labelLogin">Usuario:</label>
                    <input name="usuario" class="inputLogin" type="text" placeholder="Introduce el ID de usuario" required>

                    <label class="labelLogin">Contraseña:</label>
                    <input name="contraseña" class="inputLogin" type="password" placeholder="Introduce la contraseña" required>
                    <div class="wrap">
                        <button class="btnLogin" type="submit">Iniciar Sesión</button>
                    </div>
                </form>
        </div>
    </div>
    </body>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_crearIncidencia($isAdmin) {
    echo '
    <div id="crearIncidencia">
        <form class="formCrear" action="index.php" method="POST">
            <label class="p1">Título(*)</label>
            <label class="p2">Descripción de la Incidencia(*)</label>
            <input class="inputCrear" name="titulo" type="text" placeholder=" Introducir título de la incidencia" required>
            <textarea class="textareaCrear" name="descripción" id="Descripcion" required>Describe breve y detalladamente la incidencia...</textarea>
            
            <br>
            <label class="p3" for="Estado">Estado de la Incidencia(*)</label>
            <label class="p4" for="Prioridad">Prioridad de la Incidencia(*)</label>';

    // Mostrar las opciones del estado según si es admin o no
    echo '<select class="selectEstado" name="estado" id="Estado" required>';
    if ($isAdmin) {
        echo '<option disabled selected>Estado</option>';
        echo '<option value="Abierta">Abierta</option>';
        echo '<option value="Progreso">En Progreso</option>';
        echo '<option value="Cerrada">Cerrada</option>';
    } else {
        echo '<option value="Abierta">Abierta</option>'; // Solo permite "Abierta" para usuarios normales
    }
    echo '</select>';

    echo '
            <select class="selectPrioridad" name="prioridad" id="Prioridad" required>
                <option disabled selected>Prioridad</option>
                <option value="Poco urgente">Poco urgente</option>
                <option value="Normal">Normal</option>
                <option value="Urgente">Urgente</option>
                <option value="Muy urgente">Muy urgente</option>
            </select>

            <label class="p5" for="Categoria">Categoría de la Incidencia(*)</label>
            <label class="p6" for="archivo">Cargar archivo:</label>

            <select class="selectCategoria" name="categoria" id="Categoria" required>
                <option disabled selected>Categoría</option>
                <option value="Red (NetWorking)">Red (NetWorking)</option>
                <option value="Aplicaciones/Sistema">Aplicaciones/Sistema</option>
                <option value="Infraestructura">Infraestructura</option>
                <option value="Base de Datos">Base de Datos</option>
                <option value="Perifericos">Periféricos</option>
                <option value="Mantenimiento/Actualización">Mantenimiento/Actualización</option>
            </select>

            <div class="divArchivo">
                <input class="inputArchivo" type="file" id="archivo" name="archivo">
            </div>
            <button id="btnForm" type="submit">Mandar Incidencia</button>
        </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////  
function show_verIncidencia($incidencias) {
    echo '
        <div id="verIncidencia">
            <div class="tabla">
                <table>
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Categoría</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>';

        if (empty($incidencias) || empty($incidencias[0])) {
            echo '<tr><td colspan="6">No hay incidencias registradas.</td></tr>';
        } else {
            // Recorre el primer array y luego las incidencias
            foreach ($incidencias[0] as $incidencia) { 
            echo "<tr>";
            echo "<td>" . (isset($incidencia['Estado']) ? htmlspecialchars($incidencia['Estado']) : 'Sin estado') . "</td>";
            echo "<td>" . (isset($incidencia['Prioridad']) ? htmlspecialchars($incidencia['Prioridad']) : 'Sin prioridad') . "</td>";
            echo "<td>" . (isset($incidencia['Categoria']) ? htmlspecialchars($incidencia['Categoria']) : 'Sin categoría') . "</td>";
            echo "<td>" . (isset($incidencia['Titulo']) ? htmlspecialchars($incidencia['Titulo']) : 'Sin título') . "</td>";
            echo "<td>" . (isset($incidencia['Descripcion']) ? htmlspecialchars($incidencia['Descripcion']) : 'Sin descripción') . "</td>";
            echo "<td>" . (isset($incidencia['FechaApertura']) ? htmlspecialchars($incidencia['FechaApertura']) : 'Sin fecha') . "</td>";
            echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_tablaIncidenciasBBDD($incidencias){
    echo '
    <div id="verIncidencia">
        <div class="tabla2">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="tecnicoCol">idTecnico</th>
                        <th class="userCol">idUsuario</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th class="catCol">Categoría</th>
                        <th>Título</th>
                        <th class="descCol">Descripción</th>
                        <th>Fecha</th>
                        <th>Archivo</th>

                    </tr>
                </thead>
                <tbody>';

    if (empty($incidencias) || empty($incidencias[0])) {
        echo '<tr><td colspan="10">No hay incidencias registradas.</td></tr>';
    } else {
        // Recorre el primer array y luego las incidencias
        foreach ($incidencias[0] as $incidencia) { 
        echo "<tr>";
        echo "<td>" . (isset($incidencia['idIncidencia']) ? htmlspecialchars($incidencia['idIncidencia']) : 'Sin idIncidencia') . "</td>";
        echo "<td>" . (isset($incidencia['idTecnico']) ? htmlspecialchars($incidencia['idTecnico']) : 'Sin idTecnico') . "</td>";
        echo "<td>" . (isset($incidencia['idUsuario']) ? htmlspecialchars($incidencia['idUsuario']) : 'Sin idUsuario') . "</td>";
        echo "<td>" . (isset($incidencia['Estado']) ? htmlspecialchars($incidencia['Estado']) : 'Sin estado') . "</td>";
        echo "<td>" . (isset($incidencia['Prioridad']) ? htmlspecialchars($incidencia['Prioridad']) : 'Sin prioridad') . "</td>";
        echo "<td>" . (isset($incidencia['Categoria']) ? htmlspecialchars($incidencia['Categoria']) : 'Sin categoría') . "</td>";
        echo "<td>" . (isset($incidencia['Titulo']) ? htmlspecialchars($incidencia['Titulo']) : 'Sin título') . "</td>";
        echo "<td>" . (isset($incidencia['Descripcion']) ? htmlspecialchars($incidencia['Descripcion']) : 'Sin descripción') . "</td>";
        echo "<td>" . (isset($incidencia['FechaApertura']) ? htmlspecialchars($incidencia['FechaApertura']) : 'Sin fecha') . "</td>";
        echo "<td>" . (isset($incidencia['Archivo']) ? htmlspecialchars($incidencia['Archivo']) : 'Sin archivo') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>

        <div id="consultarIncidencia">
        <form class="formCrear2" action="index.php" method="POST">
            <label class="l1">Introduce el ID_Incidencia(*)</label>
            <input class="inputIdIncidencia" name="inputIdIncidencia" type="number" placeholder=" ID_Incidencia" required>
            <button id="btnForm2" type="submit">Buscar Incidencia</button>

        </form>
        ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_tablaDepartamentosBBDD($departamentos){
    echo '
    <div id="verIncidencia">
        <div class="tabla3">
            <table>
                <thead>
                    <tr>
                        <th>idDepartamento</th>
                        <th>Nombre Departamento</th>
                        <th>Teléfono</th>
                        <th>Email</th>

                    </tr>
                </thead>
                <tbody>';

    if (empty($departamentos) || empty($departamentos[0])) {
        echo '<tr><td colspan="6">No hay departamentos registrados.</td></tr>';
    } else {
        foreach ($departamentos[0] as $departamento) { 
        echo "<tr>";
        echo "<td>" . (isset($departamento['idDepartamento']) ? htmlspecialchars($departamento['idDepartamento']) : 'Sin idDepartamento') . "</td>";
        echo "<td>" . (isset($departamento['Nombre']) ? htmlspecialchars($departamento['Nombre']) : 'Sin Nombre') . "</td>";
        echo "<td>" . (isset($departamento['Telefono']) ? htmlspecialchars($departamento['Telefono']) : 'Sin Telefono') . "</td>";
        echo "<td>" . (isset($departamento['Email']) ? htmlspecialchars($departamento['Email']) : 'Sin Email') . "</td>";

        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>
        <form class="formCrear3" action="index.php" method="POST">
            <label class="l2">Introduce el ID_Departamento(*)</label>
            <input class="inputIdDepartamento" name="inputIdDepartamento" type="number" placeholder=" ID_Departamento" required>
            <button id="btnForm3" type="submit">Buscar Departamento</button>
        </form>
        ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_tablaUsuariosBBDD($usuarios){
    echo '
    <div id="verIncidencia">
        <div class="tabla4">
            <table>
                <thead>
                    <tr>
                        <th>idUsuario</th>
                        <th>idDepartamento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Contraseña</th>

                    </tr>
                </thead>
                <tbody>';

    if (empty($usuarios) || empty($usuarios[0])) {
        echo '<tr><td colspan="6">No hay usuarios registrados.</td></tr>';
    } else {
        foreach ($usuarios[0] as $usuario) { 
        echo "<tr>";
        echo "<td>" . (isset($usuario['idUsuario']) ? htmlspecialchars($usuario['idUsuario']) : 'Sin idUsuario') . "</td>";
        echo "<td>" . (isset($usuario['idDepartamento']) ? htmlspecialchars($usuario['idDepartamento']) : 'Sin idDepartamento') . "</td>";
        echo "<td>" . (isset($usuario['Nombre']) ? htmlspecialchars($usuario['Nombre']) : 'Sin Nombre') . "</td>";
        echo "<td>" . (isset($usuario['Apellido1']) ? htmlspecialchars($usuario['Apellido1']) : 'Sin Apellido') . "</td>";
        echo "<td>" . (isset($usuario['Email']) ? htmlspecialchars($usuario['Email']) : 'Sin Email') . "</td>";
        echo "<td>" . (isset($usuario['Contraseña']) ? htmlspecialchars($usuario['Contraseña']) : 'Sin Contraseña') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>
        <form class="formCrear3" action="index.php" method="POST">
            <label class="l3">Introduce el ID_Usuario(*)</label>
            <input class="inputIdUsuario" name="inputIdUsuario" type="number" placeholder=" ID_Usuario" required>
            <button id="btnForm3" type="submit">Buscar Usuario</button>
        </form>
        ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_tablaAdministradores($admins){
    echo '
    <div id="verIncidencia">
        <div class="tabla5">
            <table>
                <thead>
                    <tr>
                        <th>idAdmin</th>
                        <th>Rol</th>

                    </tr>
                </thead>
                <tbody>';

    if (empty($admins) || empty($admins[0])) {
        echo '<tr><td colspan="2">No hay administradores registrados.</td></tr>';
    } else {
        foreach ($admins[0] as $admin) { 
        echo "<tr>";
        echo "<td>" . (isset($admin['idUsuario']) ? htmlspecialchars($admin['idUsuario']) : 'Sin idUsuario') . "</td>";
        echo "<td>" . (isset($admin['Rol']) ? htmlspecialchars($admin['Rol']) : 'Sin Rol') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>
        <form class="formCrear3" action="index.php" method="POST">
            <label class="l3">Introduce el ID_Admin(*)</label>
            <input class="inputIdUsuario" name="inputIDAdmin" type="number" placeholder=" ID_Admin" required>
            <button id="btnForm3" type="submit">Buscar Admin</button>
        </form>
        ';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_crudIncidencias($incidencia) {

    $idIncidencia = isset($incidencia[0]['idIncidencia']) ? htmlspecialchars($incidencia[0]['idIncidencia']) : 'Sin idIncidencia';
    $idTecnico = isset($incidencia[0]['idTecnico']) ? htmlspecialchars($incidencia[0]['idTecnico']) : 'Sin idTecnico';
    $idUsuario = isset($incidencia[0]['idUsuario']) ? htmlspecialchars($incidencia[0]['idUsuario']) : 'Sin idUsuario';
    $estado = isset($incidencia[0]['Estado']) ? htmlspecialchars($incidencia[0]['Estado']) : 'Sin estado';
    $prioridad = isset($incidencia[0]['Prioridad']) ? htmlspecialchars($incidencia[0]['Prioridad']) : 'Sin prioridad';
    $categoria = isset($incidencia[0]['Categoria']) ? htmlspecialchars($incidencia[0]['Categoria']) : 'Sin categoría';
    $titulo = isset($incidencia[0]['Titulo']) ? htmlspecialchars($incidencia[0]['Titulo']) : 'Sin título';
    $descripcion = isset($incidencia[0]['Descripcion']) ? htmlspecialchars($incidencia[0]['Descripcion']) : 'Sin descripción';
    $fecha = isset($incidencia[0]['FechaApertura']) ? htmlspecialchars($incidencia[0]['FechaApertura']) : 'Sin fecha';
    $archivo = isset($incidencia[0]['Archivo']) && $incidencia[0]['Archivo'] ? htmlspecialchars($incidencia[0]['Archivo']) : 'Sin archivo';


    echo '
    <div id="crearIncidencia">
    <form class="formCrear" action="index.php" method="POST">

        <input type="hidden" name="idIncidencia" value="' . $idIncidencia . '">

        <label class="p1">Título</label>
        <label class="p2">Descripción de la Incidencia</label>
        
        <input class="inputCrear" name="titulo" type="text" placeholder="Titulo" value="' . $titulo . '" required>
        <textarea class="textareaCrear" name="descripcion" id="Descripcion" required>' . $descripcion . '</textarea>
                            
        <label class="o1">idUsuario</label>
        <input class="inputUsuario" name="idUsuario" type="text" placeholder="IdUsuario" value="' . $idUsuario . '" required>

        <label class="o2">idTecnico</label>
        <input class="inputTecnico" name="idTecnico" type="text" placeholder="IdTecnico" value="' . $idTecnico . '" required>

        <label class="o3">Fecha</label>
        <input class="inputFecha" name="fecha" type="text" placeholder="Fecha" value="' . $fecha . '" required readonly>

        <br>
        <label class="p3" for="Estado">Estado de la Incidencia</label>
        <label class="p4" for="Prioridad">Prioridad de la Incidencia</label>
        <select class="selectEstado" name="Estado" id="Estado" required>
            <option ' . ($estado ? '' : 'selected') . '>Estado</option>
            <option value="Abierta" ' . ($estado === 'Abierta' ? 'selected' : '') . '>Abierta</option>
            <option value="Progreso" ' . ($estado === 'Progreso' ? 'selected' : '') . '>En Progreso</option>
            <option value="Cerrada" ' . ($estado === 'Cerrada' ? 'selected' : '') . '>Cerrada</option>
        </select>
        <select class="selectPrioridad" name="prioridad" id="Prioridad" required>
            <option ' . ($prioridad ? '' : 'selected') . '>Prioridad</option>
            <option value="Poco urgente" ' . ($prioridad === 'Poco urgente' ? 'selected' : '') . '>Poco urgente</option>
            <option value="Normal" ' . ($prioridad === 'Normal' ? 'selected' : '') . '>Normal</option>
            <option value="Urgente" ' . ($prioridad === 'Urgente' ? 'selected' : '') . '>Urgente</option>
            <option value="Muy urgente" ' . ($prioridad === 'Muy urgente' ? 'selected' : '') . '>Muy urgente</option>
        </select>

        <label class="p5" for="Categoria">Categoría de la Incidencia(*)</label>
        <label class="p6" for="archivo">Cargar archivo:</label>

        <select class="selectCategoria" name="categoria" id="Categoria" required>
            <option ' . ($categoria ? '' : 'selected') . '>Categoría</option>
            <option value="Red (NetWorking)" ' . ($categoria === 'Red (NetWorking)' ? 'selected' : '') . '>Red (NetWorking)</option>
            <option value="Aplicaciones/Sistema" ' . ($categoria === 'Aplicaciones/Sistema' ? 'selected' : '') . '>Aplicaciones/Sistema</option>
            <option value="Infraestructura" ' . ($categoria === 'Infraestructura' ? 'selected' : '') . '>Infraestructura</option>
            <option value="Base de Datos" ' . ($categoria === 'Base de Datos' ? 'selected' : '') . '>Base de Datos</option>
            <option value="Perifericos" ' . ($categoria === 'Perifericos' ? 'selected' : '') . '>Periféricos</option>
            <option value="Mantenimiento/Actualización" ' . ($categoria === 'Mantenimiento/Actualización' ? 'selected' : '') . '>Mantenimiento/Actualización</option>
        </select>

        <div class="divArchivo">
            <input class="inputArchivo2" id="archivo" name="archivo" type="text" placeholder="Nombre del archivo" value="' . $archivo . '" readonly>
        </div>
        <button id="btnCrudActualizar" type="submit" name="accion" value="actualizarIncidencia">Actualizar Incidencia</button>
        <button id="btnCrudVolver" type="button" onclick="history.back()">Volver</button>
        <button id="btnCrudBorrar" type="submit" name="accion" value="eliminarIncidencia">Eliminar Incidencia</button>
    </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_crudDepartamentos($departamento) {

    $idDepartamento = isset($departamento[0]['idDepartamento']) ? htmlspecialchars($departamento[0]['idDepartamento']) : 'Sin idDepartamento';
    $nombre = isset($departamento[0]['Nombre']) ? htmlspecialchars($departamento[0]['Nombre']) : 'Sin Nombre';
    $telefono = isset($departamento[0]['Telefono']) ? htmlspecialchars($departamento[0]['Telefono']) : 'Sin Teléfono';
    $email = isset($departamento[0]['Email']) ? htmlspecialchars($departamento[0]['Email']) : 'Sin Email';

    echo '

    <div id="crearIncidencia">
    <form class="formCrear" action="index.php" method="POST">

        <input type="hidden" name="idDepartamento" value="' . $idDepartamento . '">

        <label class="p1">Nombre</label>
        <label class="p2">Teléfono            (Ej: 000-000-000)</label>
        <label class="p3">Email          (Ej: nombreDepartamento@miTickets.com) </label>

        <input class="inputCrear" name="nombre" type="text" placeholder="Nombre" value="' . $nombre . '" required>
        <input class="inputCrear3" name="telefono" type="text" placeholder="Teléfono" value="' . $telefono . '" required>
        <input class="inputCrear2" name="email" type="text" placeholder="Email" value="' . $email . '" required>
      
        <button id="btnCrudActualizar" type="submit" name="accion" value="actualizarDepartamento">Actualizar Departamento</button>
        <button id="btnCrudVolver" type="button" onclick="history.back()">Volver</button>
        <button id="btnCrudBorrar" type="submit" name="accion" value="eliminarDepartamento">Eliminar Departamento</button>
    </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_crudUsuarios($usuario) {

    $idUsuario = isset($usuario[0]['idUsuario']) ? htmlspecialchars($usuario[0]['idUsuario']) : 'Sin idUsuario';
    $idDepartamento = isset($usuario[0]['idDepartamento']) ? htmlspecialchars($usuario[0]['idDepartamento']) : 'Sin idDepartamento';
    $nombre = isset($usuario[0]['Nombre']) ? htmlspecialchars($usuario[0]['Nombre']) : 'Sin Nombre';
    $apellido = isset($usuario[0]['Apellido1']) ? htmlspecialchars($usuario[0]['Apellido1']) : 'Sin Apellido';
    $contraseña = isset($usuario[0]['Contraseña']) ? htmlspecialchars($usuario[0]['Contraseña']) : 'Sin Contraseña';
    $email = isset($usuario[0]['Email']) ? htmlspecialchars($usuario[0]['Email']) : 'Sin Email';

    echo '
    <div id="crearIncidencia">
    <form class="formCrear" action="index.php" method="POST">
        <input type="hidden" name="idUsuario" value="' . $idUsuario . '">

        <label class="p1">Nombre</label>
        <label class="p2">Apellido</label>
        <label class="k5">idDepartamento</label>
        <label class="k4">Contraseña</label>
        <label class="k3">Email</label>

        <input class="inputCrear4" name="nombre" type="text" placeholder="Nombre" value="' . $nombre . '" required>
        <input class="inputCrear3" name="apellido" type="text" placeholder="Apellido" value="' . $apellido . '" required>
        <input class="inputCrear7" name="idDepartamento" type="text" placeholder="idDepartamento" value="' . $idDepartamento . '" required>
        <input class="inputCrear6" name="contraseña" type="text" placeholder="Contraseña" value="' . $contraseña . '" required>
        <input class="inputCrear5" name="email" type="text" placeholder="Email" value="' . $email . '" required>

        <button id="btnCrudActualizar" type="submit" name="accion" value="actualizarUsuario">Actualizar Usuario</button>
        <button id="btnCrudVolver" type="button" onclick="history.back()">Volver</button>
        <button id="btnCrudBorrar" type="submit" name="accion" value="eliminarUsuario">Eliminar Usuario</button>
    </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_crudAdmin($admin) {
    
    $idAdmin = isset($admin[0]['idUsuario']) ? htmlspecialchars($admin[0]['idUsuario']) : 'Sin idUsuario';
    $rol = isset($admin[0]['Rol']) ? htmlspecialchars($admin[0]['Rol']) : 'Sin Rol';
    echo '
    <div id="crearIncidencia">
    <form class="formCrear" action="index.php" method="POST">

        <input type="hidden" name="idAdmin" value="' . $idAdmin . '">

        <label class="j1">Rol de Administrador</label>

        <input class="inputCrear8" name="rol" type="text" placeholder="Rol" value="' . $rol . '" required>


        <button id="btnCrudActualizar" type="submit" name="accion" value="actualizarAdmin">Actualizar Admin</button>
        <button id="btnCrudVolver" type="button" onclick="history.back()">Volver</button>
        <button id="btnCrudBorrar" type="submit" name="accion" value="eliminarAdmin">Eliminar Admin</button>
    </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_msg($msg) {
    echo "<script type='text/javascript'>alert('".$msg."');</script>";
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_verEstadisticas($mediaTiempoPrimeraActuacion, $mediaTiempoCierre, $reaperturasTotales, 
$promedioReaperturas, $promedioTecnicos, $incidenciasUsuarios, $incidenciasCategoria, $totalIncidencias, $incidenciasALaPrimera)    {
   echo '

    <div id="crearIncidencia">
    <form class="formCrear" action="index.php" method="POST">

        <input type="hidden" name="idDepartamento" value="' . $mediaTiempoPrimeraActuacion . '">

        <label class="p1">Promedio tiempo primera actuación </label>
        <label class="p2">Promedio tiempo cierre</label>
        <label class="p7">Reaperturas totales</label>
        <label class="p12">Promedio reaperturas por incidencia</label>
        <label class="p8">Usuarios/Incidencias</label>
        <label class="p10">Categoría/Incidencias</label>   
        <label class="p9">Técnicos/Incidencias</label>   
        <label class="p11">Porcentaje Incidencias</label>   
        <label class="p13">Incidencias resueltas sin reaperturas</label>   



        <input class="inputCrear" name="nombre" type="text" placeholder="" value="' .$mediaTiempoPrimeraActuacion . '" required>
        <input class="inputCrear3" name="telefono" type="text" placeholder="Teléfono" value="' . $mediaTiempoCierre . '" required>
        <input class="inputCrear10" name="email" type="text" placeholder="Email" value="' . $reaperturasTotales . '" required>
        <input class="inputCrear11" name="email" type="text" placeholder="Email" value="' . $promedioReaperturas . '" required>
        <input class="inputCrear9" name="nombre" type="text" placeholder="" value="' .$incidenciasALaPrimera . '" required>

        <div id="verIncidencia4">
            <table class="tabla6">
                <thead>
                    <tr>
                        <th>idUsuario</th>
                        <th>Nombre</th>
                        <th>Incidencias Totales</th>
                    </tr>
                </thead>
                <tbody>';

    if (empty($incidenciasUsuarios) || empty($incidenciasUsuarios[0])) {
        echo '<tr><td colspan="3">No hay registros.</td></tr>';
    } else {
        foreach ($incidenciasUsuarios[0] as $usuario) { 
        echo "<tr>";
        echo "<td>" . (isset($usuario['idUsuario']) ? htmlspecialchars($usuario['idUsuario']) : 'Sin idUsuario') . "</td>";
        echo "<td>" . (isset($usuario['Nombre']) ? htmlspecialchars($usuario['Nombre']) : 'Sin Nombre') . "</td>";
        echo "<td>" . (isset($usuario['IncidenciasTotales']) ? htmlspecialchars($usuario['IncidenciasTotales']) : 'Sin IncidenciasTotales') . "</td>";

        echo "</tr>";
        }
    }
    echo '
                </tbody>
            </table>
        </div>
    </div>
    <div id="verIncidencia3">
            <table class="tabla6">
                <thead>
                    <tr>
                        <th>idTécnico</th>
                        <th>Incidencias Totales</th>
                        <th>Tiempo promedio resolución</th>
                    </tr>
                </thead>
                <tbody>';

    if (empty($promedioTecnicos) || empty($promedioTecnicos[0])) {
        echo '<tr><td colspan="3">No hay registros.</td></tr>';
    } else {
        foreach ($promedioTecnicos[0] as $tecnico) { 
        echo "<tr>";
        echo "<td>" . (isset($tecnico['idTecnico']) ? htmlspecialchars($tecnico['idTecnico']) : 'Sin idTecnico') . "</td>";
        echo "<td>" . (isset($tecnico['IncidenciasTotales']) ? htmlspecialchars($tecnico['IncidenciasTotales']) : 'Sin IncidenciasTotales') . "</td>";
        echo "<td>" . (isset($tecnico['TiempoPromedioResolucion']) ? htmlspecialchars($tecnico['TiempoPromedioResolucion']) : 'Sin TiempoPromedioResolucion') . "</td>";

        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
        </div>
    </form>
    </div>';
    
    echo '
                </tbody>
            </table>
        </div>
    <div id="verIncidencia6">
            <table class="tabla6">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Indicencias Totales</th>
                    </tr>
                </thead>
                <tbody>';

    if (empty($incidenciasCategoria) || empty($incidenciasCategoria[0])) {
        echo '<tr><td colspan="2">No hay registros.</td></tr>';
    } else {
        foreach ($incidenciasCategoria[0] as $categoria) { 
        echo "<tr>";
        echo "<td>" . (isset($categoria['Categoria']) ? htmlspecialchars($categoria['Categoria']) : 'Sin Categoria') . "</td>";
        echo "<td>" . (isset($categoria['IncidenciasYPorcentaje']) ? htmlspecialchars($categoria['IncidenciasYPorcentaje']) : 'Sin IncidenciasTotales') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
        </div>
    </form>';

    echo '
                </tbody>
            </table>
        </div>
    <div id="verIncidencia7">
            <table class="tabla6">
                <thead>
                    <tr>
                        <th>Incidencias Totales</th>
                        <th>Abiertas</th>
                        <th>En Proceso</th>
                        <th>Cerradas</th>
                    </tr>
                </thead>
                <tbody>';

    if (empty($totalIncidencias) || empty($totalIncidencias[0])) {
        echo '<tr><td colspan="4">No hay registros.</td></tr>';
    } else {
        foreach ($totalIncidencias[0] as $total) { 
        echo "<tr>";
        echo "<td>" . (isset($total['TotalIncidencias']) ? htmlspecialchars($total['TotalIncidencias']) : 'Sin IncidenciasTotales') . "</td>";
        echo "<td>" . (isset($total['TotalAbiertas']) ? htmlspecialchars($total['TotalAbiertas']) : 'Sin IncidenciasAbiertas') . "</td>";
        echo "<td>" . (isset($total['TotalEnProceso']) ? htmlspecialchars($total['TotalEnProceso']) : 'Sin IncidenciasEnProceso') . "</td>";
        echo "<td>" . (isset($total['TotalCerradas']) ? htmlspecialchars($total['TotalCerradas']) : 'Sin IncidenciasCerradas') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
        </div>
    </form>';
    
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_verForo($mensajes, $isAdmin) {
    echo '
        <div class="verMensaje" id="verMensaje">';
            if (empty($mensajes) || empty($mensajes[0])) {
                echo '<p>No hay mensajes en el foro.</p>';
            } else {
                // Recorre el array de mensajes
                foreach (($mensajes[0]) as $mensaje) { 
                    echo '<div class="mensaje">';
                    echo "<p class='fechamsj'>" . (isset($mensaje['Fecha']) ? htmlspecialchars($mensaje['Fecha']) : 'Sin fecha') . "</p>";
                    if (isset($mensaje['idUsuario'])) {
                        $nombreUsuario = obtenerNombreUsuario($mensaje['idUsuario']);
                        echo "<p class='usermsj'>" . htmlspecialchars($nombreUsuario) . "</p><br>";
                    } else {
                        echo "<p class='usermsj'>Desconocido</p><br>";
                    }
                    echo "<p class='msj'>" . (isset($mensaje['Mensaje']) ? htmlspecialchars($mensaje['Mensaje']) : 'Sin contenido') . "</p><br>";
                    if ($isAdmin) {
                    echo '
                    <form action="index.php" method="POST">
                        <input type="hidden" name="idMensaje" value="' . htmlspecialchars($mensaje['idMensaje']) . '">
                        <button type="submit" name="borrarMensaje" class="btnBorrarMensaje">
                            <img src="images/basura.png" alt="Borrar" class="imgBorrar">
                        </button>
                    </form>';
                    }
                    echo '</div>';
                }
            }       
        echo '</div>
        <div class="crearMensaje">
            <form action="index.php" method="POST">
                <textarea name="textAreaMsj" class="textAreaMsj" placeholder="Escribe aqui el mensaje" required></textarea><br>
                <button type="submit" class="btnMensaje" name="enviarMensaje">Enviar mensaje</button>
            </form>
        </div>';


        // Script para hacer scroll al final del contenedor al cargar la página
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var verMensajeDiv = document.getElementById("verMensaje");
            // Desplaza el contenedor al final de la lista de mensajes
            verMensajeDiv.scrollTop = verMensajeDiv.scrollHeight;
        });
    </script>';


}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_verAyuda()    {
        echo '
        <div id="crearIncidencia">
            <div id="txtAyuda">
            <h2 class="txt">Teléfono de Contacto</h2>
            <h4 class="txt">912 334 212</h4> <br>

            <h2 class="txt">Email de Contacto</h2>
            <h4 class="txt">mitickets.ayuda@mitickets.com</h4> <br>
            <h2 class="txt">Si lo prefieres, explicanos brevemente el problema...</h2>
            </div>
            <form class="formProblema" action="index.php" method="POST">
                <label class="p14">Título(*)</label>
                <label class="p15">Descripción <br>del <br>Problema(*)</label>
                <input class="inputProblema" name="titulo" type="text" placeholder=" Introducir título" required>
                <textarea class="textareaProblema" name="descripción" id="Descripcion" placeholder="Describe breve y detalladamente el problema..."required></textarea>
                
                <br> 
                <button id="btnAyuda" type="submit">Enviar</button>
            </form>';
        echo '</div>';
    }
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_verTablaAyudas($ayudas)    {
    echo '
    <div id="verIncidencia">
        <div class="tabla7">
            <table>
                <thead>
                    <tr>
                        <th>idAyuda</th>
                        <th class="userCol">idUsuario</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>';
    if (empty($ayudas) || empty($ayudas[0])) {
        echo '<tr><td colspan="10">No hay incidencias registradas.</td></tr>';
    } else {
        // Recorre el primer array y luego las incidencias
        foreach ($ayudas[0] as $ayuda) { 
        echo "<tr>";
        echo "<td>" . (isset($ayuda['idAyuda']) ? htmlspecialchars($ayuda['idAyuda']) : 'Sin idAyuda') . "</td>";
        echo "<td>" . (isset($ayuda['idUsuario']) ? htmlspecialchars($ayuda['idUsuario']) : 'Sin idUsuario') . "</td>";
        echo "<td>" . (isset($ayuda['Titulo']) ? htmlspecialchars($ayuda['Titulo']) : 'Sin Titulo') . "</td>";
        echo "<td>" . (isset($ayuda['Descripcion']) ? htmlspecialchars($ayuda['Descripcion']) : 'Sin Descripcion') . "</td>";
        echo "<td>" . (isset($ayuda['Fecha']) ? htmlspecialchars($ayuda['Fecha']) : 'Sin Fecha') . "</td>";
        echo "</tr>";
        }
    }
    echo '
                    </tbody>
                </table>
            </div>
        </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function show_verPerfil($usuario, $isAdmin)   {
    
    $idUsuario = isset($usuario[0]['idUsuario']) ? htmlspecialchars($usuario[0]['idUsuario']) : 'Sin idUsuario';
    $idDepartamento = isset($usuario[0]['idDepartamento']) ? htmlspecialchars($usuario[0]['idDepartamento']) : 'Sin idDepartamento';
    $nombre = isset($usuario[0]['Nombre']) ? htmlspecialchars($usuario[0]['Nombre']) : 'Sin Nombre';
    $apellido = isset($usuario[0]['Apellido1']) ? htmlspecialchars($usuario[0]['Apellido1']) : 'Sin Apellido';
    $contraseña = isset($usuario[0]['Contraseña']) ? htmlspecialchars($usuario[0]['Contraseña']) : 'Sin Contraseña';
    $email = isset($usuario[0]['Email']) ? htmlspecialchars($usuario[0]['Email']) : 'Sin Email';
    $telf = isset($usuario[0]['Telefono']) ? htmlspecialchars($usuario[0]['Telefono']) : 'Sin Telefono';
    $direccion = isset($usuario[0]['Direccion']) ? htmlspecialchars($usuario[0]['Direccion']) : 'Sin Direccion';
    $fechaNac = isset($usuario[0]['FechaNacimiento']) ? htmlspecialchars($usuario[0]['Email']) : 'Sin FechaNacimiento';


    echo '
    <div id="crearIncidencia">

    <form class="formCrear" action="index.php" method="POST">
        <img src="images/imgPerfil.png" class="fotoPerfil">

        <input type="hidden" name="idUsuario" value="' . $idUsuario . '">

        <label class="b1">Nombre</label>
        <input class="inputPerfil1" name="nombre" type="text" placeholder="Nombre" value="' . $nombre . '" required>

        <label class="b2">Apellido</label>
        <input class="inputPerfil2" name="apellido" type="text" placeholder="Apellido" value="' . $apellido . '" required>

        <label class="b3">idDepartamento</label>
        <input class="inputPerfil3" name="idDepartamento" type="text" placeholder="idDepartamento" value="' . $idDepartamento . '" required>
       
        <label class="b4">Contraseña</label>
        <input class="inputPerfil4" name="contraseña" type="text" placeholder="Contraseña" value="' . $contraseña . '" required>

        <label class="b5">Email</label>
        <input class="inputPerfil5" name="email" type="text" placeholder="Email" value="' . $email . '" required>

        <label class="b6">Teléfono</label>
        <input class="inputPerfil6" name="email" type="text" placeholder="Email" value="' . $telf . '" required>

        <label class="b7">Dirección</label>
        <input class="inputPerfil7" name="email" type="text" placeholder="Email" value="' . $direccion . '" required>

        <label class="b8">Fecha Nacimiento</label>
        <input class="inputPerfil8" name="email" type="text" placeholder="Email" value="' . $fechaNac . '" readonly>



        <button id="btnVolverPerfil" type="submit" name="accion" value="actualizarUsuario">Actualizar Usuario</button>
        <button id="btnActualizarPerfil" type="button" onclick="history.back()">Volver</button>
    </form>
    </div>';
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
?>