<?php

    $json = null;
    $routersArray = explode("/", $_SERVER['REQUEST_URI']);
    $routersArray = array_filter($routersArray);

    if(count($routersArray) == 0)
    {
        echo json_encode(["welcome" => "bienvenido a tu api marketplace"]);
    }else{
        /** ----------------------------------------------------------
         * METHOD GET
         ** ----------------------------------------------------------*/
        if(
            count($routersArray) == 1 
            && isset($_SERVER['REQUEST_METHOD']) 
            && $_SERVER['REQUEST_METHOD'] == "GET"
            )
            {
                //=========================>
                //peticiones GET con filtro
                //=========================>
                if(isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['rel']) && isset($_GET['type']))
                {
                    //con orden
                    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
                    $orderMode = isset($_GET['orderMode']) ? $_GET['orderMode'] : null;

                    //con limite?
                    $startAt = isset($_GET['startAt']) ? $_GET['startAt'] : null;
                    $endAt = isset($_GET['endAt']) ? $_GET['endAt'] : null;

                    $table = explode("?",$routersArray[1]);
                    $response = new GetController();
                    $response->getFilterData($table[0], $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);
                }
                //===================================================>
                //peticiones GET entre tablas relacionadas sin filtro
                //===================================================>
                else if(
                    isset($_GET['rel']) && isset($_GET['type']) && explode("?", $routersArray[1])[0] == "relations" &&
                    !isset($_GET['linkTo']) && !isset($_GET['equalTo']))
                {
                    //con orden
                    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
                    $orderMode = isset($_GET['orderMode']) ? $_GET['orderMode'] : null;

                    //con limite?
                    $startAt = isset($_GET['startAt']) ? $_GET['startAt'] : null;
                    $endAt = isset($_GET['endAt']) ? $_GET['endAt'] : null;

                    $response = new GetController();
                    $response->getRelData($_GET['rel'], $_GET['type'], $orderBy, $orderMode, $startAt, $endAt);
                }
                //peticiones GET entre tablas relacionadas con filtro
                else if(
                        isset($_GET['rel']) && isset($_GET['type']) 
                        && explode("?", $routersArray[1])[0] == "relations"
                        && isset($_GET['linkTo']) && isset($_GET['equalTo'])
                    )
                {
                     //con orden
                     $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
                     $orderMode = isset($_GET['orderMode']) ? $_GET['orderMode'] : null;

                     //con limite?
                    $startAt = isset($_GET['startAt']) ? $_GET['startAt'] : null;
                    $endAt = isset($_GET['endAt']) ? $_GET['endAt'] : null;

                    $response = new GetController();
                    $response->getRelFilterData($_GET['rel'], $_GET['type'], $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);
                }
                //peticiones para busquedas
                else if(isset($_GET['linkTo']) && isset($_GET['search']))
                {
                    //con orden
                    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
                    $orderMode = isset($_GET['orderMode']) ? $_GET['orderMode'] : null;

                    //con limite?
                    $startAt = isset($_GET['startAt']) ? $_GET['startAt'] : null;
                    $endAt = isset($_GET['endAt']) ? $_GET['endAt'] : null;

                    //sin filtro
                    $response = new GetController();
                    $response->getSearchData(explode("?", $routersArray[1])[0], $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);
                }
                else{
                    //=========================>
                    //Peticiones GET sin filtro
                    //=========================>
                    
                    //con orden
                    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
                    $orderMode = isset($_GET['orderMode']) ? $_GET['orderMode'] : null;

                    //con limite?
                    $startAt = isset($_GET['startAt']) ? $_GET['startAt'] : null;
                    $endAt = isset($_GET['endAt']) ? $_GET['endAt'] : null;
                    
                    $table = explode("?",$routersArray[1]);

                    $response = new GetController();
                    $response->getData($table[0], $orderBy, $orderMode, $startAt, $endAt);
                }
                
                
            
        }

        /** ----------------------------------------------------------
         * METHOD POST
         ** ----------------------------------------------------------*/

         if(count($routersArray) == 1 && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST")
         {


            //==========================================================================
            //traemos el listado de columnas de la tabla a cambiar
            //==========================================================================
            $columns = array();
            $table = explode("?", $routersArray[1]);
            $database = RoutesController::database();
            $response = PostController::getColumnsData($table[0], $database);
            foreach($response as $key => $value)
            {
                array_push($columns, $value->item);
            }
            echo json_encode(["table"=>$table[0],"total"=> count($columns),"Columns"=>$columns]);
            return;

            //==========================================================================
            //recibimos valores post
            //==========================================================================
             if(isset($_POST))
             {



                 //==========================================================================
                 //solicitamos respuesta del controlador para agregar datos a cualquier tabla
                 //==========================================================================
                 
                 $table = explode("?", $routersArray[1]);
                 $response = new PostController();
                 $response->postData($table, $_POST);

            }      
         }
            
            /** ----------------------------------------------------------
             * METHOD PUT
             ** ----------------------------------------------------------*/
    
             if(
                 count($routersArray) == 1
                 && isset($_SERVER['REQUEST_METHOD'])
                 && $_SERVER['REQUEST_METHOD'] == "PUT" 
                )
                {
                    $json = [
                        "status_code" => 200,
                        "result" => "success",
                        "author" => "LeoMarqz",
                        "uri-parameters" => $routersArray,
                        "n-parameters" => count($routersArray),
                        "method" => $_SERVER['REQUEST_METHOD'],
                        "function" => "Update"
                ];
                }
            /** ----------------------------------------------------------
             * METHOD DELETE
             ** ----------------------------------------------------------*/
    
             if(
                 count($routersArray) == 1
                 && isset($_SERVER['REQUEST_METHOD'])
                 && $_SERVER['REQUEST_METHOD'] == "DELETE" 
                )
                {
                    $json = [
                        "status_code" => 200,
                        "result" => "success",
                        "author" => "LeoMarqz",
                        "uri-parameters" => $routersArray,
                        "n-parameters" => count($routersArray),
                        "method" => $_SERVER['REQUEST_METHOD'],
                        "function" => "Delete"
                ];
                }
        }


    // echo json_encode($json);
    // http_response_code($json["status_code"]);

        

?>