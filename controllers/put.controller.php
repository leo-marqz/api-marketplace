<?php

    class PutController 
    {
        //===================================
        //peticion put para editar datos
        //===================================
        
        public function putData($table, $data, $id, $nameId)
        {
            try {
                $response = PutModel::putData($table, $data, $id, $nameId);
                $return = $this->fncResponse($response, "putData");
            } catch (PDOException $ex) {
                $return = $this->fncResponse(null, "putData");
            }
            return $return;
        }

        /**
         * @GET request with filter
         * @param string $table
         * @param string $linkTo
         * @param string $equalTo
         */
        public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
                $return = $response;
            }catch(PDOException $ex)
            {
                $return = null;
            }
            return $return;
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