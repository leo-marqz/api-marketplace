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
         * @param string $table
         * @param array $data
         */

        public function postRegister($table, $data)
        {
            try {
                if(isset($data['password_user']) && $data['password_user'] != null)
                {
                    $passwExample = 'LeoMarqz123 = $2a$07$azybxcags23425sdg23sdegzTzc1fJgyk2RLzTegOTuPwZA07ckhy';
                    $salt = '$2a$07$azybxcags23425sdg23sdfhsd$';
                    $crypt = crypt($data['password_user'], $salt);
                    $data['password_user'] = $crypt;
                    $response = PostModel::postData($table, $data);
                    $return = $this->fncResponse($response, "postRegister -> postData");
                }
                else
                {
                    $return = $this->fncResponse(null, "postRegister -> postData");
                }
            } catch (Exception $e) {
                $return = $this->fncResponse(null, "postRegister -> postData");
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