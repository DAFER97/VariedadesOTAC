<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=52;
$Accion="Ingreso";
$Descripción="Ingreso a compras";
$_SESSION['menu'] = $_GET['objeto'];
$Auth->InsertarVenta($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
    }
     require 'shared/header.php';
     require_once 'models/Admin.php'?>


   


            <div class="full-box page-header">
        <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DATOS DEL PROVEEDOR
        </h3>
      </div>
    

<div class="container-fluid">
  <div class="col-lg-12">
    <div class="card">
            <div class="card-body">
              <form method="post" name="form_new_COMPRA" id="form_new_COMPRA">
              <input type="hidden" name="action" value="addProveedor">
              <input type="hidden" id="id_proveedor" value="1" name="id_proveedor" required>
               <div class="row">
               <div class="col-lg-4">
                 <div class="form-group">
                    <label>ID Proveedor</label>
                     <input onblur='DatosProveedor(this)' type="number" name="id_proveedor" id="id_proveedor" class="form-control">

                 </div>
               </div>
               <div class="col-lg-4">
                <div class="form-group">
                      <label>Nombre</label>
                      <input type="text" name="proveedor" id="proveedor" class="form-control" disabled required>
                </div>
               </div>
               <div class="col-lg-4">
                 <div class="form-group">
                      <label>Teléfono</label>
                      <input type="number" name="telfono" id="telfono" class="form-control" disabled required>
                 </div>
                 </div>
                <div class="col-lg-4">
                   <div class="form-group">
                      <label>Dirreción</label>
                      <input type="text" name="direccion" id="direccion" class="form-control" disabled required>
                        </div>

                        </div>
                        <div id="div_registro_cliente" style="display: none;">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                       </div>
                  </div>
                </form>
            </div>
    </div>
  </div>
</div>


      <div class="full-box page-header">
        <h3 class="text-left">
          <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DATOS DE COMPRA
        </h3>
      </div>

      <div class="row">
                   <div class="col-lg-6">
                     <div class="form-group">
                          
                     </div>
                   </div>
                 <div class="col-lg-6">
                      <label>Acciones</label>
                  <div id="acciones_venta" class="form-group">
                           <a href="#" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                           <a href="javascript:void(0);" id="guardarCompra2"  class="btn btn-primary" ><i class="fas fa-save"></i> Generar Compra</a>
                  </div>
                </div>
            </div>  

            <input type="hidden" id="precio_">    

            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="100px">Código</th>
                                            <th>Descripción</th>
                                          <th>  Fecha de compra </th>
                                            <th width="100px">Cantidad</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                        <tr>
                                            <td>
                                              <input onblur="producto(this)" type="number" name="id_producto" id="id_producto">
                                            </td>
                                            <td id="nombre_producto">-</td>
                                            <td id="stock">-</td>
                                            <td>
                                              <input onkeyup="data()" type="text" name="cantidad" id="cantidad" value="0" min="1" >
                                            </td>
                                            <td id="precio_venta" class="textright">
                                                0.00
                                                
                                            </td>
                                            <td id="txt_precio_total" class="txtright">0.00</td>
                                            <td><a href="javascript:void(0);" id="add-producto-temp" class="btn btn-warning text-center"> Agregar </a></td>
                                        </tr>
                                        <tr>
                                            <th>Código</th>
                                            <th colspan="2">Descripción</th>
                                            <th>Cantidad</th>
                                            <th class="textright">Precio</th>
                                            <th class="textright">Precio Total </th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_Productos">
                                        <!-- Contenido ajax -->
                                    </tbody>
                                    <tfoot id="detalle_totales">
                                         <!-- Contenido ajax -->
                                    </tfoot>
                                </table>
                            </div>




    <?php require 'shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>

<script type="text/javascript">
   


    function data(){
     total = ( parseInt($('#precio_').val())  *  parseInt($('#cantidad').val())  ); 
     $('#txt_precio_total').text(total); 
    }



    function datosProveedor() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow'
        };

        fetch(`../controllers/api.php?action=DatosProveedor&id=${ $('#id_proveedor').val() }`, requestOptions)
          .then(response => response.json())
          .then(result => {
              if (result.ok==false) {
                $('#proveedor').val('');
                $('#telefono').val('');
                $('#direccion').val('');
              }
              $('#proveedor').val(result.nombre_cliente);
              $('#telfono').val(result.telefono_cliente);
              $('#direccion').val(result.direccion_cliente);
          })
          .catch(error => console.log('error', error));
     }


     var datos = false;
     function producto() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow'
        };

        fetch(`../controllers/api.php?action=producto&codigo=${ $('#id_producto').val() }`, requestOptions)
          .then(response => response.json())
          .then(result => {
              datos = result;
               

              if (result.ok==false) {
                $('#nombre_producto').text('');
                $('#stock').text('');
                $('#precio_venta').text('');
                $('#txt_precio_total').text('');
                $('#cantidad').val('');
              }


                $('#nombre_producto').text(result.nombre_producto);
                $('#stock').text(result.stock);
                $('#precio_venta').text(result.precio_venta);
                $('#precio_').val(result.precio_venta);
                $('#txt_precio_total').text('0.00');
                $('#cantidad').val('0');


          })
          .catch(error => console.log('error', error));
     }


     $('#add-producto-temp').click(function() {
        var table = $('#table_Productos');

        total = ( parseInt($('#precio_').val())  *  parseInt($('#cantidad').val())  );


        /*if (parseInt($('#cantidad').val()) > parseInt(datos.stock)) {
          alert('La cantidad seleccionada no es válida');
          return;
        }

        row = $(`<tr class="producto_row">

                    <td>${ $('#id_producto').val() }  <input class="form-control id_producto" type="hidden" value="${ $('#id_producto').val() }">
                    </td>

                    <td>${ datos.nombre_producto }  <input class="form-control nombre_producto" type="hidden" value="${  datos.nombre_producto  }">
                    </td>


                    <td>${ datos.stock }  <input class="form-control stock" type="hidden" value="${ datos.stock }">
                    </td>


                    <td>${ $('#cantidad').val() }  <input class="form-control cantidad" type="hidden" value="${ $('#cantidad').val() }">
                    </td>

                    <td>${ datos.precio_venta }  <input class="form-control precio_venta" type="hidden" value="${ datos.precio_venta }">
                    </td>

                    <td>${ total }  <input class="form-control total" type="hidden" value="${ total }">
                    </td>

                 </tr>`);

        table.append(row);

        $('#nombre_producto').text('');
        $('#stock').text('');
        $('#precio_venta').text('');
        $('#precio_').val('');
        $('#txt_precio_total').text('');
        $('#cantidad').val('');
        $('#id_producto').val('')



     });



     $('#guardarCompra2').click(function(){

        cont = 0;
        var producto_row = [];
        $('.producto_row').each(function(index,person){
            id_producto_ = $(person).find('.id_producto').val();
            cantidad_ = $(person).find('.cantidad').val();
            total_ = $(person).find('.total').val();

            stock_ = $(person).find('.stock').val();

            producto_row.push({id_producto_, cantidad_, total_ , stock_});
            cont++;
        });

        if (cont == 0) {
          Swal.fire({
                            title: '¡Oops!',
                            text: '¡Ingrese los campos requeridos!',
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger m-l-10'
                });
          return;
        }

        var form_data = new FormData();
        form_data.append("action","guardarCompra2");
        form_data.append("DNI",$('#id_cliente').val() );

        form_data.append("productos_row", JSON.stringify(producto_row) );

        fetch('../controllers/api.php', {
            method: 'POST',
            body: form_data
        }).then((resp) => resp.json())
        .then(server => {
            if (server.ok==1) {
                location.href = "Ventas&objeto=35";
            }
        }).catch(err=>{ console.log(err); });

     });





</script>


