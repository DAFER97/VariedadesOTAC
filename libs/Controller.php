<?php

class Controller {

    //metodo para llamar los modelos
    public  function model($model){
       require_once '../models/'.$model.'.php';
       return new $model();
    }

    //metodo para llamar las vistas
    public  function view($view){
        if(file_exists('views/'.$view.'.php')){
            include 'views/'.$view.'.php';
        }else{
            echo 'la vista no existe';
        }
    }

}

