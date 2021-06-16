<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=26;
$Accion="Ingreso";
$Descripción="Ingreso de venta";
$_SESSION['menu'] = $_GET['objeto'];
$Auth->InsertarVenta($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'admin/shared/header.php';
     require_once 'models/Admin.php'?>


	
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DATOS DEL CLIENTE
				</h3>
			</div>
		

<a href='VentasNew' class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
            <div class="card-body">
              <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta">
              <input type="hidden" name="action" value="addCliente">
              <input type="hidden" id="id_cliente"  name="id_cliente" required>
               <div class="row">
               <div class="col-lg-4">
                 <div class="form-group">
                    <label>DNI O CODIGO</label>
                     <input onblur='datosCliente(this)' type="text"onkeypress="return SoloNumeros(event);" pattern=".{3,99}" maxlength="13"name="DNI" id="DNI" class="form-control">

                 </div>
               </div>
               <div class="col-lg-4">
                <div class="form-group">
                      <label>NOMBRE</label>
                      <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" disabled required>
                </div>
               </div>
               <div class="col-lg-4">
                 <div class="form-group">
                      <label>TELÉFONO</label>
                      <input type="number" name="telfono_cliente" id="telfono_cliente" class="form-control" disabled required>
                 </div>
                 </div>
                <div class="col-lg-4">
                   <div class="form-group">
                      <label>DIRECCIÓN</label>
                      <input type="text" name="direccion_cliente" id="direccion_cliente" class="form-control" disabled required>
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
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DATOS DE VENTA
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
                           <a href="javascript:location.reload();" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                           <a href="javascript:guardarCompra();" id="guardarCompra"  class="btn btn-primary" ><i class="fas fa-save"></i> Generar Venta</a>
                  </div>
                </div>
            </div>	

            <input type="hidden" id="precio_">		

						<div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th  width="100px">Código</th>
                                            <th>Descripción</th>
                                            <th>Stock</th>
                                            <th width="100px">Cantidad</th>
                                            <th class="textright">Precio</th>
                                            <th class="textright">Precio Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                        <tr>
                                            <td>
                                              <input onblur="producto(this)"  maxlength="5" onkeypress="return SoloNumeros(event);" pattern=".{3,99}" type="text" name="id_producto" id="id_producto">
                                            </td>
                                            <td id="nombre_producto">-</td>
                                            <td id="stock">-</td>
                                            <td>
                                              <input onkeyup="data()" type="text" name="cantidad" id="cantidad" value="0" min="1" >
                                            </td>
                                            <td id="precio_venta" class="textright">
                                                0
                                                
                                            </td>
                                            <td id="txt_precio_total" class="txtright">0.00</td>
                                            <td><a href="javascript:void(0);" id="add-producto-temp" class="btn btn-warning text-center"> Agregar </a></td>
                                        </tr>
                                        <tr>
                                            <th>Código</th>
                                            <th colspan="2">Descripción</th>
                                            <th>Cantidad</th>
                                            <th class="textright">Precio</th>
                                            <th class="textright">Precio Total</th>
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


	<?php require 'admin/shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>


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



    function datosCliente() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow'
        };

        fetch(`../controllers/api.php?action=DatosCliente&dni=${ $('#DNI').val() }`, requestOptions)
          .then(response => response.json())
          .then(result => {
              if (result.ok==false) {
                $('#nombre_cliente').val('');
                $('#telfono_cliente').val('');
                $('#direccion_cliente').val('');
              }
              $('#nombre_cliente').val(result.nombre_cliente);
              $('#nombre_cliente').val(result.nombre_cliente);
              $('#telfono_cliente').val(result.telefono_cliente);
              $('#direccion_cliente').val(result.direccion_cliente);
              $('#id_cliente').val(result.id_cliente);
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


        if (parseInt($('#cantidad').val()) > parseInt(datos.stock)) {
          alert('La cantidad seleccionada no es válida');
          return;
        }

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

            if (parseInt(value) > parseInt(stock)) {
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




     function guardarCompra(){ 

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
        form_data.append("action","guardarCompra");
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

     };


    




</script>