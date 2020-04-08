<?php
require('../../rq/empmod.php');
// Archivo Requerido para mostrar los Empleados en la tabla de abajo 
?>
<!-- Aplicacion VUE -->
<div id="vueapp">
  <form>
    <h2 style="text-align: center">Administración<br>De Empleado<br></h2>
    <!-- Campos de Inserccion -->
    <div class="form-row">
      <div class="col">
        <input v-model="idEmpleado" value aria-required="true" class="form-control" type="text" placeholder="Número de Documento" name="id_empleado" required>
      </div>
      <div class="col">
        <input v-model="email" value aria-required="true" class="form-control" type="text" placeholder="Correo Electrónico" name="email" required>
      </div>
    </div><br>
    <div class="form-row">
      <div class="col">
        <input v-model="celular" value aria-required="true" class="form-control" type="text" placeholder="Celular" name="celular" required>
      </div>
      <div class="col">
        <input v-model="pass" value aria-required="true" class="form-control" type="password" placeholder="Contraseña" name="pass" required>
      </div>
    </div><br>
    <div class="form-row">
      <div class="col">
        <input v-model="nombres" value aria-required="true" class="form-control" type="text" placeholder="Nombres" name="nombres" required>
      </div>
      <div class="col">
        <input v-model="apellidos" value aria-required="true" class="form-control" type="text" placeholder="Apellidos" name="apellidos" required>
      </div>
    </div><br>
    <div class="form-row">
      <div class="col">
        <input v-model="telefonos" value aria-required="true" class="form-control" type="text" placeholder="Telefonos" name="telefonos" required>
      </div>
      <div class="col">
        <input v-model="direccion" value aria-required="true" class="form-control" type="text" placeholder="Dirección" name="direccion" required>
      </div>
    </div>
    <!-- Campos de Inserccion -->
    <div style="text-align: center" class="form-row">
      <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
      <div style="text-align: center" class="col"><br>
        <input class="btn btn-primary" type="reset" value="Limpiar">
        <input class="btn btn-primary" type="button" value="Registrar" name="registro" @click="enviarDatos();">
        <a class="btn btn-primary" data-toggle="collapse" href="#TablaEmp" role="button" aria-expanded="false" aria-controls="TablaProv">Mostrar Registros</a>
      </div>
      <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
    </div>
  </form>
  <!-- Script del VUE.js -->
  <script type="text/javascript">
    var vm = new Vue({
      el: '#vueapp', //elemento HTML afectado por el VUE
      data: { //enlazar datos
        // formulario:{
        idEmpleado: '',
        email: '',
        pass: '',
        nombres: '',
        apellidos: '',
        celular: '',
        telefonos: '',
        direccion: ''
        // }
      },
      mounted() { //Se lanza cada vez que se recarga la pagina
        // alert('funciona');
      },
      methods: { //metodos personalizados
        enviarDatos: function(event) {
          const formulario = new FormData();
          formulario.set('idEmpleado', this.idEmpleado);
          formulario.set('email', this.email);
          formulario.set('pass', this.pass);
          formulario.set('nombres', this.nombres);
          formulario.set('apellidos', this.apellidos);
          formulario.set('celular', this.celular);
          formulario.set('telefonos', this.telefonos);
          formulario.set('direccion', this.direccion);
          //peticion por AXIOS con POST
          axios({
            method: 'POST', //metodo
            url: 'mods/empleados/procesar/adempleados.php', //archivo donde se envía la información
            data: formulario
          }).then(function(respuesta) { //Respuesta del servidor
            console.log(respuesta);
            alert(respuesta.data.msg);
            if (respuesta.data.exito === true) { //Redirección a la página de listado
              cargarEmp();
            }
          }).catcht(function(error) {
            console.log(error);
          })
        }
      }

    });
  </script>
</div>
<br>
<!-- Aplicacion VUE -->

<div class="collapse multi-collapse container mt-5" id="TablaEmp">
  <!-- Tabla donde estará la información -->
  <table class="table table-dark table-hover">
    <thead>
      <tr>
        <!-- Columnas de la Tabla -->
        <th scope="col">Número de Documento</th>
        <th scope="col">Nombres</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Correo Electronico</th>
        <th scope="col">Celular</th>
        <th scope="col">Telefonos</th>
        <th scope="col">Direccion</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <?php
    if ($fila = mysqli_fetch_array($resultset)) {
      echo '<br>';
      // Ciclo que permite rellenar las filas de la tabla
      do {
        echo "<tbody><tr>";
        echo "<th scope='row'>" . $fila["numero_identificacion"] . "</th>";
        // Variable que toma el id del Registro
        $id = $fila["numero_identificacion"];
        echo "<td>" . $fila["Nombre"] . "</td>";
        echo "<td>" . $fila["Apellido"] . "</td>";
        echo "<td>" . $fila["email"] . "</td>";
        echo "<td>" . $fila["Celular"] . "</td>";
        echo "<td>" . $fila["Telefono"] . "</td>";
        echo "<td>" . $fila["Direccion"] . "</td>";
        //Función para editar el Registro
        echo "<td><a onclick='edEmp(" . $id . ");'>Editar</a></td></tr>";
      } while ($fila = mysqli_fetch_array($resultset));
      echo "<br>";
    } else {
      echo "</table><div class='alert alert-warning' role='alert'> No se encontraron registros </div>";
    }
    $conexion->close();
    ?>
  </table>
  <!-- Tabla donde estará la información -->
</div>
<script>
  $(".alert-success").delay(4000).slideUp(200, function() {
    $(this).alert - success('close');
  });
</script><br><br><br>
<div id="busquedadatos">
    <form method="" action="" style="text-align: center" class="form"><br>
        <div style="text-align: center" class="form-row">
            <div class="col-3">
            </div>
            <div class="col-1">
                <label style="color:black; display: block; text-align:right; width: 100%; height: calc(2.25rem + 2px); padding: 0.375rem 0.75rem; font-size: 1rem;" for="vrBuscar">Datos</label>
            </div>
            <div class="col-2">
                <input type="text" name="vrBuscar" id="vrBuscar" v-model="vrBuscar">
            </div>
            <div class="col-3">
                <select name="buscarX" id="buscarX" v-model="buscarX" class="form-control">
                    <option value="id">Buscar por ID</option>
                    <option value="nombre">Buscar por Nombre</option>
                </select>
            </div>
        </div>
        <div style="text-align: center" class="form-row">
            <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
            <div style="text-align: center" class="col"><br>
                <button @click="CargarDatosBusqueda()" name="buscar" id="buscar" class="btn btn-primary">Buscar</button>                                
            </div>
            <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
        </div>
    </form><br>
    <div id="Resultado">
    </div>
</div>
<script type="text/javascript">
    $(Document).ready(function() {
        $("#buscar").on("click", (e) => {
            e.preventDefault();
            CargarDatosBusqueda();
        })
    })

    function CargarDatosBusqueda() {
        let buscaX = "";
        let vrBusca = "";
        buscaX = document.getElementById("buscarX").value;
        vrBusca = document.getElementById("vrBuscar").value;
        $.ajax({
            type: "POST",
            url: "mods/empleados/procesar/serchemp.php",
            data: {
                buscarX: buscaX,
                vrBuscar: vrBusca
            },
            success: function(r) {
                $('#Resultado').html(r);
            }
        });
    }
</script>