<?php
//our entry into the web application

//all the requests will pass through this file


//we read the product intent into two variables
//$controller and $action passed over query string
if(isset($_GET["controller"]) && isset($_GET["action"])){
  $controller=$_GET["controller"];
  $action=$_GET["action"];
}
else
{
//in case the product doesnt give us this values, we set them to a default controller and action
  $controller="Tracking";
  $action="index";
}

//we load up our routing code, that will execute the action on the controller
//the function for calling the actions on the controller
function call($controller,$action){

    //first we load the php file, with the correct controller and model
    require_once("controller/$controller.php");

//we call the action function on the controller
    $controller=new $controller;
    $controller->{$action}();
}


$controllers = array('Tracking' => ['index','getHistory']);


//we check, if the invoked action is part of our mvc code
//without this check, a malicous product, could execute arbitrary code
if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('errorController', 'error');
    }
} else {
    call('errorController', 'error');
}

?>