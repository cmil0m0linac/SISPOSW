<?php
require('../../../datos/conexioncore.php');
$resultset = mysqli_query($conexion, "SELECT Id_Proveedor, Nombre_Prov, Direccion, Email, Telefonos FROM proveedores");