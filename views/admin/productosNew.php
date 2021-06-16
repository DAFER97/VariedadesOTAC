<?php

if (!isset($_SESSION['admin'])) {
    header("location:" . base_url);
}

require 'shared/header.php';
require_once 'models/Admin.php';
require_once 'models/Auth.php';
$Auth = new Auth();
$No_Pantalla=38;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO DE CREACION DE PRODUCTOS POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción); ?>
<title>Producto</title>
<!-- Page content -->
<section class="full-box page-content">
    
    <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; NUEVO PRODUCTO
                </h3>
            </div>
    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="productos"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PRODUCTOS</a>
            </li>
        </ul>
    </div>
    <!-- Content -->
    <div class="container-fluid">
        <form method="POST"  action="<?php echo base_url . "admin/Crearproducto" ?>" class="form-neon" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información del Producto</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="nombre_producto" class="bmd-label-floating">Nombre del Producto</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="nombre_producto" id="nombre_producto"  minlength="2" maxlength="40">
                        </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="desc_producto" class="bmd-label-floating">Descripcion del Producto</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="desc_producto" id="desc_producto"  minlength="2" maxlength="40">
                        </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="precio_venta" class="bmd-label-floating">Precio del Producto</label>
                                <input class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{1,99}" required  name="precio_venta" id="precio_venta"  minlength="1" maxlength="20">
                       </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Proveedor</label>
                                <select name="proveedor_" class="form-control" id="exampleFormControlSelect1">
                                    <option value="0">Seleccionar</option>
                                  <?php $i;
                                    $admin = new Admin();
                                    $result=$admin->getproveedores();
                                    foreach($result as $r){ 


                                     echo "<option value=".$r['id_proveedor']."  >".$r['proveedor']."</option>";
                                }?>
                                </select>
                              </div>
                        </div>


                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Categoria</label>
                                <select name="Categoria_" class="form-control" id="exampleFormControlSelect1">
                                    <option value="0">Seleccionar</option>

                                <?php $i;
                                    $admin = new Admin();
                                    $result=$admin->ObtenerCategoria();
                                    foreach($result as $r){ 


                                     echo "<option value=".$r['id_categoria']."  >".$r['nombre_categoria']."</option>";
                                }?>



                                </select>
                              </div>
                        </div>








                </div>
            </fieldset>
            <br>
            <fieldset>
                <legend><i class="fas fa-user-lock"></i> &nbsp; Cantidades del Producto</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <label for="cantidad_max" class="bmd-label-floating">Cantidad Maxima</label>
                            <input type="number" name="cantidad_max" id="cantidad_max"  minlength="1" maxlength="20">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="cantidad_min" class="bmd-label-floating">Cantidad Minima</label>
                            <input type="number" name="cantidad_min" id="cantidad_min"  minlength="1" maxlength="20">
                        </div>
                        <input type="hidden" name="stock" id="stock"  value="0">
                        <input type="hidden" name="fecha_registro"  value="<?php echo date('Y-m-d') ?>" >

                        <!-- <div class="col-12 col-md-2">
                            <label for="stock" class="bmd-label-floating">Disponible</label>
                            <input type="number" name="stock" id="stock"  minlength="2" maxlength="1">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="fecha_registro" class="bmd-label-floating">Fecha Registro</label>
                            <input type="date" class="form-control" name="fecha_registro" id="fecha_registro"  minlength="1" maxlength="20">
                        </div> -->
            <p class="text-center" style="margin-top: 20px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR FORMULARIO</button>
                &nbsp; &nbsp;
                <button type="submit" name="crear" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                <br>
                <?php if (isset($_SESSION['msg'])) : ?>
                    <strong class="alert-danger text-center"><?= $_SESSION['msg'] ?></strong>
                <?php endif;
                unset($_SESSION['msg']); ?>
            </p>
        </form>
    </div>
</section>

<script>
            function SoloNumeros(evt)
            {
            if(window.event){
            keynum = evt.keyCode;
            }
            else{
            keynum = evt.which;
            }

            if((keynum > 47 && keynum < 58) || keynum == 8 || keynum== 13)
            {
            return true;
            }
            else
            {
            alert("Ingresar solo numeros");
            return false;
            }
            }

        </script>
</main>
<?php require 'shared/footer.php'; ?>


