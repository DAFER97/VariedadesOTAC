<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'autoload.php';
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php';


if(isset($_GET['controller'])){
	$nombre_controlador = $_GET['controller'].'Controller';

}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
	$nombre_controlador = controller_default;
	
}else{

    echo 'no existe la pagina';
	exit();
}

if(class_exists($nombre_controlador)){	
	$controlador = new $nombre_controlador();
	if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
		$action = $_GET['action'];
		$controlador->$action();
	}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
		$action_default = action_default;
		$controlador->$action_default();
	}else{
        //show_error();
      // echo 'no existe la pagin';
       
       echo "<script type='text/javascript'>";
    echo "window.history.back(-1)";
    echo "</script>";
	}
}else{
    // show_error();
    echo 'no existe la pagina';
}
