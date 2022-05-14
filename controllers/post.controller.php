<?php

    class PostController 
    {

        /**
         * Properties
         */
        private $salt = '$2a$07$azybxcags23425sdg23sdfhsd$';


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
                    $crypt = crypt($data['password_user'], $this->salt);
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

        public function postLogin($table, $data)
        {
            try {
                $response = GetModel::getFilterData($table, 'email_user', $data['email_user'], null, null, null, null);
                if($response == false)
                { 
                    $return = $this->fncResponse(null, "postLogin", "Wrong email");
                }
                else
                {
                    $crypt = crypt($data['password_user'], $this->salt); 
                    if($response[0]->password_user == $crypt)
                    {
                        $return = $this->fncResponse($response, "postLogin");
                    }
                    else
                    {
                        $return = $this->fncResponse(null, "postLogin", "Wrong password");
                    }
                }
            } catch (Exception $e) {
                $return = $this->fncResponse(null, "postLogin -> getFilterData");
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
        public function fncResponse($response, $method, $error = null)
        {
            if(!empty($response))
            {
                if(isset($response[0]->password_user)) unset($response[0]->password_user);
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
                if(!is_null($error))
                {
                    $json['status'] = 400;
                    $json['result'] = $error;
                } 
            }
            return $json;
        }
    }
    


?>