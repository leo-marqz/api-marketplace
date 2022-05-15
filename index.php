<?php 

    /*
    ** Config :: CORS :: Cross Origin Resource Sharing || Comparticion de recursos de distintos origenes.
    */
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Header: Origin, X-Requested-With, Content-Type, Acept');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json; charset=utf-8');
    //end config...

    //ROUTER
    require_once("controllers/router.controller.php");
    
    //GET
    require_once("controllers/get.controller.php");
    require_once("models/get.model.php");
    
    //POST
    require_once("controllers/post.controller.php");
    require_once("models/post.model.php");

    //PUT
    require_once("models/put.model.php");
    require_once("controllers/put.controller.php");
    
    //DELETE
    require_once("models/delete.model.php");
    require_once("controllers/delete.controller.php");

    //VENDOR
    require_once("vendor/autoload.php");

    $router = new RoutesController();
    $router->index();

    return;

?>