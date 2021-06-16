<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        *{
            font-family: Arial, serif;
        }
        body{
            max-width: 300px;
            border: 1px #f2f2f2 solid;
            padding: 2px;
        }
        table{
            width: 100%;
        }
        .content-center {
            align-content: center;
        }
        .left{
            text-align: left;
        }
        .center{
            text-align: center;
        }
        .right{
            text-align: right;
        }
        .f10{
            font-size: 10px;
        }
        .b{
            font-weight: bold;
        }
        .line-height{
            line-height: 5px;
        }
        footer {
            clear: both; 
        }

        @media  print {
            body {
                margin-top: 0%;
                margin-bottom: 0%;
            }
        }
    </style>
    
</head>
<body>


<?php 
 



  include_once('config/db.php');
  $db = Database::connect();
  
  $idventa = $_GET['id'];
  $q = "SELECT
            tbl_ventas.fecha_venta, 
            tbl_ventas.total_venta, 
            tbl_ventas.id_venta, 
            tbl_clientes.DNI, 
            tbl_clientes.nombre_cliente
        FROM
         tbl_ventas
         INNER JOIN tbl_clientes ON tbl_ventas.id_cliente = tbl_clientes.id_cliente
         WHERE id_venta = '$idventa'";
  $result  = mysqli_query($db,$q);
  $row     = mysqli_fetch_assoc($result);


?>
        <div id="listin_cont">
                <table class="f10 content-center">
            <tbody class="center">
                <tr>
                    <td class="b" style="font-size: 13px;">VARIEDADES OTAC</td>
                </tr>
                <tr>
                    <td>RTN: 08261986000773</td>
                </tr>
                
                <tr>
                    <td>Teléfono: +504 9730-1206 </td>
                </tr>
                <tr>
                    <td>Email:  otacagropecuaria@gmail.com</td>
                </tr>
                <tr>
                <td></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="f10 left">
            <tbody>
                <tr>
                    <td class="b">No. PE- <?= $row['id_venta']  ?>  </td>
                </tr>
                <tr>
                    <td style="text-transform: capitalize;">Fecha: <?= $row['fecha_venta']  ?></td>
                </tr>

                <tr>
                    <td style="text-transform: capitalize;">Cliente: <?= $row['nombre_cliente']  ?></td>
                </tr>

                <tr>
                    <td style="text-transform: capitalize;">DNI o codigo: <?= $row['DNI']  ?></td>
                </tr>





                <tr>
                    <td>Moneda: Lempira - HNL</td>
                </tr>
                            </tbody>
        </table>
        <hr>
        <table class="f10" style="width: 100%;" >
            <thead>
                <tr class="left">
                    <th style="width: 20%"></th>
                    <th style="width: 58%"></th>
                    <th style="width: 20%"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="left b">
                    <td>CANT.</td>
                    <td>DESCRIPCIÓN</td>
                    <td>TOTAL</td>
                </tr>


                    <?php 

                         $q2 = "SELECT
                                tbl_detalle_venta.id_venta, 
                                tbl_detalle_venta.id_producto, 
                                tbl_detalle_venta.cantidad, 
                                tbl_detalle_venta.precio_total, 
                                tbl_productos.nombre_producto, 
                                tbl_productos.desc_producto, 
                                tbl_productos.precio_venta
                            FROM
                             tbl_detalle_venta
                            INNER JOIN tbl_productos ON  tbl_detalle_venta.id_producto = tbl_productos.id_producto WHERE id_venta = '$idventa'  ";
                            $result2  = mysqli_query($db,$q2);

                            $totalItens = 0;
                            $Subtotal = 0;
                            while (list($id_venta, $id_producto, $cantidad, $precio_total, $nombre_producto, $desc_producto, $precio_vent) = mysqli_fetch_array($result2)) {
                                $totalItens = $totalItens+$cantidad;
                                $Subtotal = $Subtotal + $precio_total;
                                $ISV = $Subtotal    * 0.15;
                                $SUBT = $Subtotal - $ISV; 
                                echo '<tr>
                                            <td style="margin-top: 0;padding-top:0;">
                                                    '.$cantidad.' 
                                             </td>
                                             <td>
                                                  '.$nombre_producto.'
                                                  <br>
                                                   '.$desc_producto.'
                                              </td>
                                              <td>
                                                L '.number_format($precio_total,2).'
                                              </td>
                                        </tr>
                                        <tr><td colspand="3"></td> </tr>


                                        ';
                                  
                            }




                     ?>


                        


                    


                    </tr>
                            </tbody>
        </table>
        <hr>
        <p style="page-break-before: auto">
        <table class="f10" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 60%"> </th>
                    <th style="width: 40%"> </th>
                </tr>
            </thead>
            <tbody class="left">
                <tr class="left">
                    <td><?= $totalItens  ?> Total items</td>
                </tr>
                                <tr>
                                   <td>Subtotal:</td>
                        <td>L <?= number_format($SUBT,2)  ?></td> 
                                    </tr>
                                <tr>
                                            <td>Importe Exonerado:</td>
                        <td>L 0.00</td> 
                                    </tr>
                                <tr>
                                            <td>Importe Exento:</td>
                        <td>L 0.00</td> 
                                    </tr>
                                <tr>
                                            <td>Descuento:</td>
                        <td>L 0.00</td> 
                                    </tr>
                                <tr>
                                            <td>Importe Gravado(15%):</td>
                        <td>L 00.00</td> 
                                    </tr>
                                <tr>
                                            <td>Importe Gravado(18%):</td>
                        <td>L 0.00</td> 
                                    </tr>
                                <tr>
                                            <td>ISV 15 (15%):</td>
                        <td><?= number_format($ISV,2)  ?></td> 
                                    </tr>
                                <tr>
                                    </tr>
                                <tr class="b">
                    <td>TOTAL A PAGAR</td>
                    <td>L <?= number_format($Subtotal,2)  ?></td>
                </tr>
            </tbody>
        </table>
        

        

        <br><br><br><br><br><br><br><br><br><br><br><br>        <p class="f10 center"></p>
        <table class="f10 center">
            <tbody>
                                                            <tr>
                            <td>.</td>
                        </tr>
                                                                                
                <tr>
                    <td>LA FACTURA ES BENEFICIO DE TODOS</td>
                </tr>
                <tr>
                    <td>¡EXÍJALA!</td>
                </tr>
            </tbody>
        </table>
            </div>
    
</body>



<script src="public/js/jquery.js"></script>




<script type="text/javascript"> 

$('#print_btn').click(function () {
    var printContents = document.getElementById('print_area').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + printContents + "</body>";
    window.print();
    document.body.innerHTML = originalContents;
});

</script>

<script>
    if(is_mobile() == false){
        if (typeof jsPrintSetup != "undefined") { 
            // set portrait orientation
            jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);

            jsPrintSetup.setOption('paperSizeType', 34);


            // set top margins in millimeters
            jsPrintSetup.setOption('marginTop', 0.20);
            jsPrintSetup.setOption('marginBottom', 0.20);
             jsPrintSetup.setOption('marginLeft', 0.20);
             jsPrintSetup.setOption('marginRight', 0.20);


             //jsPrintSetup.setOption(' unwriteableMarginLeft', 0.21);
             //jsPrintSetup.setOption(' unwriteableMarginRight', 0.21);
         // set page header
            // set page header
            //jsPrintSetup.setOption('headerStrLeft', 'TallerAlpha');
            jsPrintSetup.setOption('headerStrLeft', '');
            jsPrintSetup.setOption('headerStrCenter', '');
            jsPrintSetup.setOption('headerStrRight', '');
            // set empty page footer
            jsPrintSetup.setOption('footerStrLeft', '');
            jsPrintSetup.setOption('footerStrCenter', '');
            jsPrintSetup.setOption('footerStrRight', '');

            jsPrintSetup.setOption('scaling', '100%');
            // clears user preferences always silent print value
            // to enable using 'printSilent' option
            jsPrintSetup.clearSilentPrint();
            // Suppress print dialog (for this context only)
            jsPrintSetup.setOption('printSilent', 1);
            // Do Print 
            // When print is submitted it is executed asynchronous and
            // script flow continues after print independently of completetion of print process! 
            jsPrintSetup.print();
            // next commands
        }else{
            window.print();
        }
   
        }


        function is_mobile() {

    var isMobile = false; //initiate as false
    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
     isMobile = true;
     }*/
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    return isMobile;
}
</script>