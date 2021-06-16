<?php

// El autoload nos sirve para no estar requiriendo todos los controladores que creemos
//con solo requerirlo una vez en el index trae todos.

function controllers_autoload($classname)
{
	include 'controllers/' . $classname . '.php';
}

spl_autoload_register('controllers_autoload');