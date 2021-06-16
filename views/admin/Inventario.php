<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=26;
$Accion="INGRESO";
$Descripción="INGRESO AL MODULO DE INVENTARIO";

$Auth->InsertarVenta($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
    }
     require 'shared/header.php';
     require_once 'models/Admin.php'?>


   


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
                      <label></label>
                  <div id="acciones_venta" class="form-group" style=" text-align: right; padding-right: 60px; ">
                            <a href="javascript:location.reload();" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                           <a href="javascript:void(0);" id="guardarCompra"  class="btn btn-primary" ><i class="fas fa-save"></i>&nbsp;Guardar compra</a>
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
                                            <th>Stock</th>
                                            <th width="100px">Agregar Cantidad</th>
                                            <th class="textright">Precio</th>
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
                                            <td><a href="javascript:void(0);" id="add-producto-temp" class="btn btn-warning text-center"> Agregar </a></td>
                                        </tr>
                                        <tr>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Stock</th>
                                            <th>Cantidad</th>
                                            <th class="textright">Precio</th>
                                            <th>Precio total</th>
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
 
    $(document).ready(function(){
        $('#table_Productos').on('click','.btn-delete', function(){
           let table = $(this).parent().parent().parent();
           let row_to_remove = $(this).parent().parent();
           let index = row_to_remove.index();
           row_to_remove.remove();
        })
    });
    editar_produto = 1;

    function data(){
     total = ( parseInt($('#precio_').val())  *  parseInt($('#cantidad').val())  ); 
     $('#txt_precio_total').text(total); 
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

        //if (parseInt(datos.cantidad_max) <  parseInt($('#cantidad').val()) ) {
          //alert('error cantida maxima superada');
         // return;
        //}

        var table = $('#table_Productos');

        total = ( parseInt($('#precio_').val())  *  parseInt($('#cantidad').val())  );


        

        $t = false;
        $('.producto_row').each(function(index,person){
            id_producto_ = $(person).find('.id_producto').val();
            if ($('#id_producto').val() == id_producto_ ) {
              alert('esteproduto ya fue aregado');
              $t = true;
            }
        });

        if ($t) { return; }

        if (parseInt($('#cantidad').val()) <= 0) {
          alert('Cantidad no valida');
          return;
        }




         row = $(`<tr class="producto_row">

                    <td>${ $('#id_producto').val() }  <input class="form-control id_producto" type="hidden" value="${ $('#id_producto').val() }">
                    </td>

                    <td>${ datos.nombre_producto }  <input class="form-control nombre_producto" type="hidden" value="${  datos.nombre_producto  }">
                    </td>


                    <td>  ${ datos.stock }  <input   class="form-control stock" type="hidden" value="${ datos.stock }">
                    </td>


                    <td >
                        <span class="cantidad-${ editar_produto }" >${ $('#cantidad').val()  }</span>    
                         <input class="form-control cantidad c-${ editar_produto }" type="hidden" value="${ $('#cantidad').val() }">
                    </td>

                    <td>${ datos.precio_venta }  
                        <input class="form-control precio_venta" type="hidden" value="${ datos.precio_venta }">
                    </td>

                    <td>
                       <span class="total-${ editar_produto }" >${ total }</span>      
                       <input class="form-control total t-${ editar_produto }" type="hidden" value="${ total }">
                    </td>

                    <td> 
                      <button onclick="editar(${ $('#cantidad').val() }, ${ datos.stock }, ${ datos.precio_venta }, ${ editar_produto })"  class="btn btn-sm btn-danger">Editar</button>
                      <button  class="btn btn-sm btn-danger btn-delete">Eliminar</button>
                    </td>

                 </tr>`);

        table.append(row);

        $('#nombre_producto').text('');
        $('#stock').text('');
        $('#precio_venta').text('');
        $('#precio_').val('');
        $('#txt_precio_total').text('');
        $('#cantidad').val('');
        $('#id_producto').val('');

        editar_produto = editar_produto+1;




     });

     function editar(catidad, stock, precio_venta, id){
        Swal.fire({
          title: 'Modificar Cantidad',
          input: 'number',
          inputValue: $('.c-'+id).val(),
          inputPlaceholder: 'Enter your password',
          inputAttributes: {
            maxlength: 10,
            autocapitalize: 'off',
            autocorrect: 'off'
          },
          inputValidator: (value) => {
            if (parseInt(value) <= 0 ) {
              return 'Cantidad no valida';
            }

           


            total = ( parseInt(precio_venta)  *  parseInt(value));

            $('.cantidad-'+id).text(value);
            $('.c-'+id).val(value);

            $('.total-'+id).text(total);
            $('.t-'+id).val(total);
          }
        });
     }







     $('#guardarCompra').click(function(){

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
        form_data.append("action","ajustedeinventario"); 
        form_data.append("productos_row", JSON.stringify(producto_row) );

        fetch('../controllers/api.php', {
            method: 'POST',
            body: form_data
        }).then((resp) => resp.json())
        .then(server => {
            if (server.ok==1) {
                location.href = "inventariolista";
            }
        }).catch(err=>{ console.log(err); });

     });





</script>