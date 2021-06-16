





<!-- Inicio footer PHP -->
</div>
</div>
<!-- Fin row -->
<footer id="footer-bar" class="row">
<p id="footer-copyright" class="col-xs-12">
<!-- www.incanatoit.com - Todos los derechos reservados. -->
</p>
</footer>
</div>
<!-- Fin content wrapper-->
</div>
</div>
</div>

<div id="config-tool" class="closed">
<a id="config-tool-cog">
<i class="fa fa-cog"></i>
</a>
<div id="config-tool-options">
<h4>Opciones del Tema</h4>
<ul>
<li>
<div class="checkbox-nice">
<input type="checkbox" id="config-fixed-header"/>
<label for="config-fixed-header">
Cabecera Fija
</label>
</div>
</li>
<li>
<div class="checkbox-nice">
<input type="checkbox" id="config-fixed-sidebar"/>
<label for="config-fixed-sidebar">
Menú fijo a la izquierda
</label>
</div>
</li>
<li>
<div class="checkbox-nice">
<input type="checkbox" id="config-fixed-footer"/>
<label for="config-fixed-footer">
Pie Fijo
</label>
</div>
</li>
</ul>
<br/>
<h4>Color del Tema</h4>
<ul id="skin-colors" class="clearfix">
<li>
<a class="skin-changer" data-skin="theme-navyBlue" data-toggle="tooltip" title="Navy Blue" style="background-color: #34495e;">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-white" data-toggle="tooltip" title="White/Green" style="background-color: #2ecc71;">
</a>
</li>
<li>
<a class="skin-changer blue-gradient" data-skin="theme-blue-gradient" data-toggle="tooltip" title="Gradient">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-greenSea" data-toggle="tooltip" title="Green Sea" style="background-color: #6ff3ad;">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-amethyst" data-toggle="tooltip" title="Amethyst" style="background-color: #9b59b6;">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-blue" data-toggle="tooltip" title="Blue" style="background-color: #7FC8BA;">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-red" data-toggle="tooltip" title="Red" style="background-color: #e74c3c;">
</a>
</li>
<li>
<a class="skin-changer" data-skin="theme-whbl" data-toggle="tooltip" title="White/Blue" style="background-color: #1ABC9C;">
</a>
</li>
</ul>
</div>
</div>
 
 <!-- NOTIFLIX ENLACE PARA ALERTASSSS -->
 <script src="../public/Notiflix-2.5.0/dist/Notiflix-aio-2.5.0.min.js"></script>

<script src="../public/js/demo-skin-changer.js"></script>  
<script src="../public/js/jquery.js"></script>
<script src="../public/js/bootstrap.js"></script>
<script src="../public/js/jquery.nanoscroller.min.js"></script>
<script src="../public/js/demo.js"></script>  
 
<script src="../public/js/moment.min.js"></script>
<script src="../public/js/daterangepicker.js"></script>
 
<script src="../public/js/scripts.js"></script>
<script src="../public/js/pace.min.js"></script>


<!-- para fechas y tiempo -->
<script src="<?=base_url?>/public/moment/moment.min.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>


<!-- Datatable -->


<script src="<?= base_url ?>public/datatables/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url ?>public/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url ?>public/datatables/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url ?>public/datatables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>



<!-- Botones DataTables -->

<script src="<?= base_url ?>public/datatables/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url ?>public/datatables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!--Libreria para exportar Excel-->
<script src="<?= base_url ?>public/datatables/jszip/jszip.min.js"></script>

<!--Librerias para exportar PDF-->
<script src="<?= base_url ?>public/datatables/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url ?>public/datatables/pdfmake/vfs_fonts.js"></script>
<!--Librerias para botones de exportación-->
<script src="<?= base_url ?>public/datatables/datatables-buttons/js/buttons.html5.min.js"></script>

<!-- sweetaler2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- jejej -->

<script src="../public/datatables/datatables-buttons/js/buttons.bootstrap.min.js"></script>




<script src="../public/js/bootbox.min.js"></script> 
<script src="../public/js/bootstrap-select.min.js"></script>  
<script src="../public/js/demo-skin-changer.js"></script>

 <script>
  $('#pass, #pass1').on('keyup', function () {
    if ($('#pass').val() == $('#pass1').val()) {
        $('#message').html('Verificación de contraseña correcto').css('color', 'green');
    } else 
        $('#message').html('Las contraseñas nuevas no son iguales').css('color', 'red');
});
// $('select option').each(function() {
//    var thisAttr = $(this).attr('disabled');
//    if(thisAttr = "disabled") {
//       $(this).hide();
//    }
// })
 </script>



</body>

</html>