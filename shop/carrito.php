<?php
include "../datos/conexioncore.php";
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Shopping Cart</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php include('include/header.php'); ?>

  <!--Heading Banner Area Start-->
  <section class="heading-banner-area pt-30">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="heading-banner">
            <div class="breadcrumbs">
              <ul>
                <li><a href="index.php">Inicio</a><span class="breadcome-separator">></span></li>
                <li>Shopping Cart</li>
              </ul>
            </div>
            <div class="heading-banner-title">
              <h1>Carrito de Compras</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Heading Banner Area End-->
  <!--Shopping Cart Area Start-->
  <div class="shopping-cart-area mt-20">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <form class="shop-form">
            <div class="wishlist-table table-responsive">
              <table>
                <thead>
                  <tr>
                    <th class="product-remove"></th>
                    <th class="product-name">
                      <span class="nobr">Nombre del producto</span>
                    </th>
                    <th class="product-name">
                      <span class="nobr">Descripcion</span>
                    </th>
                    <th class="product-quantity">
                      <span class="nobr">Cantidad</span>
                    </th>
                    <th class="product-price">
                      <span class="nobr"> Valor Unitario </span>
                    </th>
                    <th class="product-total-price">
                      <span class="nobr"> Precio Total </span>
                    </th>
                  </tr>
                </thead>
                <?php
                                $total = 0;
                                $flete = 15000;
                                $query = $conexion->query("SELECT * FROM carrito WHERE usuario = '" . $_SESSION['id'] . "' AND estado = '1'");
                                if ($query->num_rows > 0) {
                                    while ($row = $query->fetch_assoc()) {
                                        $cantidad = $conexion->query("SELECT COUNT(producto) as cantidad FROM `carrito` WHERE estado <> 0 and usuario = '" . $_SESSION['id'] . "' and producto = '" . $row['producto'] . "'");
                                        $cant = $cantidad->fetch_assoc();
                                        $queryprod = $conexion->query("SELECT * FROM productos WHERE Id_Producto = '" . $row['producto'] . "'");
                                        $rowprod = $queryprod->fetch_assoc();

                                ?>
                <tbody>
                  <tr>
                    <td class="product-remove">
                      <?php echo "<a onclick='deletprod(" . $row['producto'] . ")'>×</a>" ?>
                    </td>
                    <td class="product-name">
                      <span><?php echo $rowprod['Nombre'] ?></span>
                    </td>
                    <td class="product-name">
                      <span><?php echo $rowprod['Descripcion'] ?></span>
                    </td>
                    <td class="product-quantity">
                      <span><?php echo $cant['cantidad'] ?></span>
                    </td>
                    <td class="product-price">
                      <span><ins><?php echo $rowprod['ValorUnitario'] ?></ins></span>
                    </td>
                    <td class="product-total-price">
                      <span><?php echo number_format($cant['cantidad'] * $rowprod['ValorUnitario']) ?></span>
                    </td>
                  </tr>
                  <?php $total = $total + ($cant['cantidad'] * $rowprod['ValorUnitario']);
                                            $numprod = 0;
                                            $numprod = $numprod + $cant['cantidad'];
                                            ?>
                </tbody>
                <?php }
                                } ?>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6" style="float: right;">
          <div class="shopping-cart-total">
            <h2>Total compra</h2>
            <div class="shop-table table-responsive">
              <table>
                <tbody>
                  <tr class="cart-subtotal">
                    <td data-title="Subtotal"><span><?php echo $total ?></span></td>
                  </tr>
                  <tr class="shipping">
                    <td data-title="Domicilio">Valor del flete nacional: <Span><?php echo $flete ?></Span></td>
                  </tr>
                  <tr class="order-total">
                    <td data-title="Total"><span><strong><?php echo number_format($total + $flete) ?></strong></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="proceed-to-checkout">
              <a data-toggle="modal" data-target="#checkout" class="checkout-button ">Proceder al pago</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Shopping Cart Area End-->
  <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="reg" aria-hidden="true"
    style="z-index: 99999">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <br>
          <h4 class="modal-title w-100 font-weight-bold">Verifique sus Datos</h4>
        </div>
        <div class="modal-body mx-3">
          <form action="factura.php" method="post">
            <!-- Campos de Inserccion -->
            <?php
                        $clientex = $conexion->query("SELECT Id_Cliente, id_identificacion, Id_usuario, Nombre, Apellido, Direccion, Celular, Telefono,  numero_identificacion, pass, email FROM personas p, clientes c, identificacion i, usuarios u where c.Persona = p.id_persona and p.Identificacion = i.id_identificacion and c.Usuario = '" . $_SESSION['id'] . "'");
                        $cli = $clientex->fetch_assoc();
                        ?>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <label>Nombre Completo</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Nombre Completo' name='name' required value='" . $cli['Nombre'] . " " . $cli['Apellido'] . "'>" ?>
                </div>
                <div class="col-md-6">
                  <label>Número de Documento</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Número Documento' name='id' required value='" . $cli['numero_identificacion'] . "'>" ?>
                </div>
                <div class="col-md-6 mt-2">
                  <label>Departamento</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Departamento' name='departamento' required value=''>" ?>
                </div>
                <div class="col-md-6 mt-2">
                  <label>Ciudad</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Ciudad' name='ciudad' required value=''>" ?>
                </div>
                <div class="col-md-6 mt-2">
                  <label>Dirección</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Direccion' name='direc' required value='" . $cli['Direccion'] . "'>" ?>
                </div>
                <div class="col-md-6 mt-2">
                  <label>Contacto</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Contacto' name='phone' required value='" . $cli['Celular'] . "'>" ?>
                </div>
              </div>
            </div>
            <hr class="my-3">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12" style="text-align: left">
                  <label>Tarjeta de Credito</label>
                  <div class="col-md-1">
                    <input style="height: inherit" name="payment_method" checked="checked" value="bacs" type="radio">
                  </div>
                  <img src="img/payment/payment.png" alt="Metodos de Pago">
                </div>

                <div class="col-md-6 mt-2">
                  <label>Titular de la tarjeta</label>
                  <?php echo "<input class='form-control' type='text' placeholder='Titular' name='tname' required value='" . $cli['Nombre'] . " " . $cli['Apellido'] . "'>" ?>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="cardNumber">Número de Tarjeta</label>
                  <input type="text" maxlength="16" id="cardNumber" name="cardNumber" class="form-control"
                    placeholder="Ingrese el número de tarjeta" value="">
                </div>
                <div class="col-md-6 mt-2">
                  <label for="expDate">Fecha de Vencimiento</label>
                  <input type="date" id="expDate" name="expDate" class="form-control" placeholder="mm/aa" value="">
                </div>
                <div class="col-md-6 mt-2">
                  <label for="verificationCode">Codigo CVV</label>
                  <input type="password" maxlength="4" id="verificationCode" name="verificationCode"
                    class="form-control" placeholder="Ingrese el código de seguridad" value="">
                </div>
              </div>
            </div>

            <!-- Campos de Inserccion -->
            <div class="mb-3" style="text-align: center">
              <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
              <div style="text-align: center" class="col-md-12 mt-5">
                <input class="btn btn-primary" type="submit" value="Pagar" name="pagofactura">
              </div>
              <!-- Botonera para Limpiar el Formulario o hacer un Registro -->
            </div>
          </form>
        </div>
        <div class="modal-footer my-2" style="text-align: center"><br><br>
          <button class="btn btn-danger " data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <?php include('include/footer.php'); ?>

  <?php include('include/modal.php'); ?>

  <?php include('include/scripts.php'); ?>
  <script src="../app/src/js/axios.js"></script>
  <script src="../app/src/js/vue.js"></script>
  <script src="../app/src/js/script.js"></script>
  </body>

</html>