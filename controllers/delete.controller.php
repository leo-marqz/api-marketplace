<?php

    class DeleteController
    {
        //================================================
        //Peticion DELETE para eliminar datos de una tabla
        //================================================

        public function deleteData($table, $id, $nameId)
        {
            try
            {
                $response = DeleteModel::deleteData($table, $id, $nameId);
                $return = $this->fncResponse($response, "deleteData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "deleteData");
            }
            return $return;

        }

        /**
         * @response controller responses
         */
        public function fncResponse($response, $method)
        {
            if( !empty($response))
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