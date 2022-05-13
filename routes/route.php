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

            //========================================================================
            //quitamos el primer y el ultimo elemento del array $columns
            //========================================================================
            
            array_shift($columns);
            array_pop($columns);
            
            //========================================================================
            //validamos si las variables $_POST coinciden con las del arreglo $columns
            //========================================================================
            
            $count = 0;
            
            foreach ($columns as $key => $value)
            {
                if(array_keys($_POST)[$key] == $value)
                {
                    $count++;
                }
                else
                {
                    $json = [
                        "status"=> 400,
                        "result" => "Error: Fields in the form do not match the database"
                    ];
                    echo json_encode($json, http_response_code($json['status']));
                    return;
                }
            }
            
            //========================================================================
            //validamos que $_POST y $columns tengan la misma cantidad de variables
            //========================================================================

            if(count($columns) == $count)
            {
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
                     $result = $response->postData($table[0], $_POST);
                     echo json_encode($result, http_response_code($result['status']));
                    return;
                }      
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

                    //==========================================================================
                    //preguntamos si viene ID
                    //==========================================================================

                    if(isset($_GET['id']) && isset($_GET['nameId']))
                    {
                        
                        

                        $table = explode("?", $routersArray[1])[0];
                        $linkTo = $_GET['nameId'];
                        $equalTo = $_GET['id'];
                        $orderBy = null;
                        $orderMode = null;
                        $startAt = null; 
                        $endAt = null;
                        $data = 0;


                        //==========================================================================
                        //validamos si existe el ID
                        //==========================================================================
                        
                        $response = new PutController();
                        $existsData = $response->getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
                        
                        if($existsData){
                            
                            //==========================================================================
                            //Capturamos los datos del formulario
                            //==========================================================================
                            
                            $_PUT = array(); //variable personal, esta no es parte de variables globales de php
                            parse_str(file_get_contents('php://input'), $_PUT);

                            //==========================================================================
                            //traemos el listado de columnas de la tabla a cambiar
                            //==========================================================================
                            $columns = array();
                            $table = explode("?", $routersArray[1])[0];
                            $database = RoutesController::database();
                            $columnsName = PostController::getColumnsData($table, $database);
                            foreach($columnsName as $key => $value)
                            {
                                array_push($columns, $value->item);
                            }

                            //========================================================================
                            //quitamos el primer y el ultimo elemento del array $columns
                            //========================================================================
                            
                            array_shift($columns);
                            array_pop($columns);
                            array_pop($columns);

                            // var_dump($columns);
                            
                            //========================================================================
                            //validamos si las variables $_PUT coinciden con las del arreglo $columns
                            //========================================================================
                            
                            $count = 0;
                            foreach (array_keys($_PUT) as $key => $value) 
                                    $count = array_search($value, $columns);
                            


                            if($count > 0)
                            {
                                //==========================================================================
                                //solicitamos respuesta del controlador para editar cualquier tabla
                                //==========================================================================

                                $json = $response->putData($table, $_PUT, $_GET['id'], $_GET['nameId']);
                                echo json_encode($json, http_response_code($json['status']));
                                return;
                            }else
                            {
                                $json = [
                                    "status"=> 400,
                                    "result" => "Error: Fields in the form do not match the database"
                                ];
                                echo json_encode($json, http_response_code($json['status']));
                                return;
                            }

    
                        }else{
                            $json = [
                                "status" => 404,
                                "result" => "Error: the id is not found in the database" ,
                                "error_in" => "getFilterData [ PUT ]"
                            ];
                            echo json_encode($json, http_response_code($json['status']));
                        }
                        return;

                    }

               
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
                    /**
                     * Preguntamos si viene Id
                     */
                    if(isset($_GET['id']) && isset($_GET['nameId']))
                    {
                        /**
                         * Validamos que exista el Id
                         */
                        $table = explode("?", $routersArray[1])[0];
                        $linkTo = $_GET['nameId'];
                        $equalTo = $_GET['id'];
                        $orderBy = null;
                        $orderMode = null;
                        $startAt = null;
                        $endAt = null;

                        $exists = PutController::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
                        if($exists)
                        {
                            /**
                             * Solicitamos respuesta del controlador
                             */
                             $response = new DeleteController();
                             $json = $response->deleteData($table, $_GET['id'], $_GET['nameId']);
                             echo json_encode($json, http_response_code($json['status']));
                             return;
                        }
                        else
                        {
                            $json = [
                                "status"=>404,
                                "result"=>"this category does not exist"
                            ];
                            echo json_encode($json, http_response_code($json['status']));
                            return;
                        }
                    }
                }
        }


    // echo json_encode($json);
    // http_response_code($json["status_code"]);

        

?>