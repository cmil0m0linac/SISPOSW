<?php
//Archivo PHP con la Conexion
require('../../../../datos/conexioncore.php');
//Condicional que recibe los datos desde archivo principal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT id_identificacion, usuario from clientes c, personas p, identificacion i, usuarios u where c.Persona = p.id_persona and p.Identificacion = i.id_identificacion and c.Usuario = u.Id_usuario and i.numero_identificacion = " . $_POST['idCliente'];
    $resultado = $conexion->query($sql)
        or die('Error al intentar realizar la consulta');
    $fila = null;
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_array(MYSQLI_ASSOC);
    } else {
        echo "El Cliente que intenta editar no existe";
        $conexion->close();
        exit;
    }
    $sql1 = "SELECT Id_usuario, usuario from clientes c, personas p, identificacion i, usuarios u where c.Persona = p.id_persona and p.Identificacion = i.id_identificacion and c.Usuario = u.Id_usuario and i.numero_identificacion = " . $_POST['idCliente'];
    $resultado1 = $conexion->query($sql1)
        or die('Error al intentar realizar la consulta2');
    $fila1 = null;
    if ($resultado1->num_rows > 0) {
        $fila1 = $resultado1->fetch_array(MYSQLI_ASSOC);
    } else {
        echo "El Cliente que intenta editar no existe";
        $conexion->close();
        exit;
    }
    $id_cliente = $_POST['idCliente'];
    //Condicional que impide inserccion de Registros vacios
    if ($id_cliente != null) {        
        $email = $_POST['email'];
        $celular = $_POST['celular'];
        $pass = $_POST['pass'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $telefonos = $_POST['telefonos'];
        $direccion = $_POST['direccion'];
        //Respuesta por Defecto del servidor
        $respuesta = [];
        $respuesta['msg'] = 'Registro no guardado';
        $respuesta['exito'] = false;
        //Sentencias SQL que hace la inserccion del Registro
        $sqlcli = "UPDATE identificacion SET ";
        $sqlcli .= "numero_identificacion = '$id_cliente'";
        $sqlcli .= " WHERE numero_identificacion = $id_cliente"; //Tenga en cuenta el espacio de la condición WHERE

        $sqlcli1 = "UPDATE personas SET ";
        $sqlcli1 .= "Nombre = '$nombres',";
        $sqlcli1 .= "Apellido = '$apellidos',";
        $sqlcli1 .= "Direccion = '$direccion',";
        $sqlcli1 .= "Celular = '$celular',";
        $sqlcli1 .= "Telefono = '$telefonos'";
        $sqlcli1 .= " WHERE identificacion = " . $fila['id_identificacion']; //Tenga en cuenta el espacio de la condición WHERE

        $sqlcli2 = "UPDATE usuarios SET ";
        $sqlcli2 .= "email = '$email',";
        $sqlcli2 .= "pass = '$pass'";
        $sqlcli2 .= " WHERE Id_usuario = " . $fila1['Id_usuario']; //Tenga en cuenta el espacio de la condición WHERE        

        //Condicional que da la respuesta al archivo principal
        if (($conexion->query($sqlcli) === TRUE) && ($conexion->query($sqlcli1) === TRUE) && ($conexion->query($sqlcli2) === TRUE)) {
            $respuesta['msg'] = 'Registro modificado correctamente';
            $respuesta['exito'] = true;
        }
    } else {
        $respuesta['error'] = '' . $conexion->error;
        $respuesta['msg'] = 'Error en la modificación del registro';
    }

    $conexion->close();
    echo json_encode($respuesta);
    die();
}
