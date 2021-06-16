<?php

class inicioController
{

    public function index(){
        require_once 'views/login.php';
    }

    public function Recuperacion(){
        require_once 'views/Recuperacion.php';
    }

    public function Correo(){
        require_once 'views/Correo.php';
    }

    public function Pregunta(){
        require_once 'views/Pregunta.php';
    }
    public function RestablecerContraCorreo(){
        require_once 'views/RestablecerContraCorreo.php';
    }

    public function RestablecerContraPregunta(){
        require_once 'views/RestablecerContraPregunta.php';
    }

    public function login(){
        require_once 'views/login.php';
    }

    public function Conexion(){
        require_once 'config/db.php';
    }

    public function registro(){
        require_once 'views/registro.php';
    }
    public function PreguntaSeguridad(){
        require_once 'views/PreguntaSeguridad.php';
    }

    public function cambiodecontra(){
         require_once 'views/cambiocontra.php';
    }

    public function cambiodecontraprime(){
        require_once 'views/cambioContraPrimVez.php';
    }

    public function Preguntaprime(){
        require_once 'views/preguntaadmin.php';
    }
    public function Escritorio(){
        require_once 'views/admin/principal.php';
    }

    public function db(){
        require_once 'database/db.php';
    }

 

}
