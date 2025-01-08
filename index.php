<?php
error_reporting(E_ALL);				// directivas para activar 
ini_set('display_errors', '1');	    // la notificación de errores

session_start();			//avisa php que se usa sesion
	
include_once 'view/view.inc.php';
include_once 'controller/controller.inc.php'; 
include_once 'model/model.inc.php'; 


show_header();
show_content();


?>