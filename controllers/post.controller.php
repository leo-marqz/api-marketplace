<?php

    class PostController 
    {
        /**====================================>
         **== Peticion post para crear datos ==>
         **====================================>
         */

        public function postData($table, $data)
        {
            try {
                $response = PostModel::postData($table, $data);
                $return = $this->fncResponse($response, "postData");
            } catch (PDOException $ex) {
                $return = $this->fncResponse(null, "postData");
            }
            return $return;
        }

        
        
        /**
        * @response columns - table
        */
        public static function getColumnsData($table, $database)
        {
            return PostModel::getColumnsData($table, $database);
        }

         /**
         * @response controller responses
         */
        public function fncResponse($response, $method)
        {
            if(!empty($response))
            {
                $json = [
                    "status" => 200,
                    "result" => $response
                ];
            }else
            {
                $json = [
                    "status" =>404,
                    "result" => "Not Found",
                    "error_in" => $method
                ];
            }
            return $json;
        }
    }
    


?>