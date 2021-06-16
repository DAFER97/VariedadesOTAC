<?php
//if (strlen(session_id()) < 1) 
//  session_start();
require_once 'models/Admin.php';
$admin = new Admin();
$result = $admin->getmenus();

?>
<!DOCTYPE html>
<html>

<!-- Mirrored from www.ravijaiswal.com/Afro-v.1.1/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Mar 2017 03:12:20 GMT -->

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Variedades-OTAC</title>

   <!-- iconos -->
  <link rel="stylesheet" href="<?=base_url?>/public/fontawesome-free/css/all.min.css">


  <!-- SWEETALERT2 -->
  <link rel="stylesheet" href="<?=base_url?>/public/sweetalert2/sweetalert2.min.css">


  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap/bootstrap.min.css" />

  <script src="../public/js/demo-rtl.js"></script>


  <link rel="stylesheet" type="text/css" href="../public/css/libs/font-awesome.css" />
  <link rel="stylesheet" type="text/css" href="../public/css/libs/nanoscroller.css" />

  <link rel="stylesheet" type="text/css" href="../public/css/compiled/theme_styles.css" />

  <link rel="stylesheet" href="../public/css/libs/daterangepicker.css" type="text/css" />

  <link type="image/x-icon" href="favicon.png" rel="shortcut icon" />

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  <!-- DATATABLES -->
  <!-- <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
   <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" /> -->


 <!-- Datatable -->
 <link rel="stylesheet" href="<?=base_url?>public/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url?>public/datatables/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- BOTONES DATATABLE -->
<link rel="stylesheet" href="<?=base_url?>public/datatables/datatables-buttons/css/buttons.bootstrap4.min.css">




  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">


</head>

<body>
<div id="theme-wrapper">
<header class="navbar" id="header-navbar">
<div class="container">
<a href="principal" id="logo" class="navbar-brand">
<img src="../public/img/logo.png" alt="" class="normal-logo logo-white"/>
<img src="../public/img/logo-black.png" alt="" class="normal-logo logo-black"/>
<img src="../public/img/logo-small.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
</a>
<div class="clearfix">
<button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
<span class="sr-only">Navegacion</span>
<span class="fa fa-bars"></span>
</button>
<div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
<ul class="nav navbar-nav pull-left">
<li>
<a class="btn" id="make-small-nav">
<i class="fa fa-bars"></i>
</a>
</li>
</ul>
</div>
<div class="nav-no-collapse pull-right" id="header-nav">
<ul class="nav navbar-nav pull-right">
<li class="dropdown language hidden-xs">
<a class="btn dropdown-toggle" data-toggle="dropdown">
Opciones
<i class="fa fa-caret-down"></i>
</a>
<ul class="dropdown-menu">
<li class="item">
<a href="http://localhost/variedades-OTAC/admin/salir">
Salir
</a>
</li>
</ul>
</li>
</ul>
</div>
</div>
</div>
</header>
<div id="page-wrapper" class="container">
<div class="row">
<div id="nav-col">
<section id="col-left" class="col-left-nano">
<div id="col-left-inner" class="col-left-nano-content">

  <!-- Sidebar Menu -->
  <nav class="collapse navbar-collapse navbar-ex1-collapse"  id="sidebar-nav" >
      <ul class="nav nav-pills nav-stacked">
        <?php foreach ($result as $row) { ?>
          <li>
        <?php  if ($row['estado'] == 'activo') {
            if ($row['idPadre'] == 0) { ?>
              <a class="dropdown-toggle" data-toggle="collapse" data-target="#<?php echo $row['objeto']; ?>" aria-expanded="false" aria-controls="collapseLayouts">
                <i class="<?= $row['icono']; ?>"></i>

                <span><?php echo $row['objeto']; ?></span>
                <i class="right fas fa-angle-right"></i>
              </a>
            <?php } ?>
            <ul class="collapse" id="<?php echo $row['objeto']; ?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              
              <?php
                $cod = $row['id_objeto'];
                
                $m = $admin->getmenu($cod);
    
                foreach ( $m as $roww) { ?>
                <li>
                  <a class="nav-link" href="<?= base_url . $roww['url'] . '&objeto=' . $roww['id_objeto']; ?>">
                    <i class="<?= $roww['icono']?> nav-icon"></i>
                       <?php echo $roww['objeto']; ?></a>
                </li>
                <?php } ?>
           
            </ul>
        <?php }
        } ?>
        </li>
         </ul>
         </nav>
  </div>
 
  



</div>
</section>
<div id="nav-col-submenu"></div>
</div>
<!-- Inicio Wrapper -->
<div id="content-wrapper">
<div class="row">
<div class="col-lg-12">
<!-- Fin header PHP -->
