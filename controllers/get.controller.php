<?php

    class GetController 
    {
        /**
         * @GET unfiltered request
         * @param string $table
         */
        public function getData($table, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getData($table, $orderBy, $orderMode, $startAt, $endAt);
                $return = $this->fncResponse($response, "getData");
               
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
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
                $return = $this->fncResponse($response, "getFilterData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getFilterData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
        }


        /**
         * @GET relationship between tables without filter
         */
        public function getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt);
                $return = $this->fncResponse($response, "getRelData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getRelData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
        }

        /**
         * @GET relationship between tables with filter    
         */
        public function getRelFilterData($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getRelFilterData($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
                $return = $this->fncResponse($response, "getRelFilterData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getRelFilterData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
        }

        /**
         * @param string $table
         * @param string $linkTo
         * @param string $search
         * @GET search for data in a table
         */
        public function getSearchData($table, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getSearchData($table, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
                $return = $this->fncResponse($response, "getFilterData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getFilterData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
        }

        /**
         * @GET search engine between related tables 
         * @param string $table
         * @param string $linkTo
         * @param string $equalTo
         */
        public function getSearchRelData($rel, $type, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
        {
            try
            {
                $response = GetModel::getSearchRelData($rel, $type,$linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
                $return = $this->fncResponse($response, "getSearchRelData");
            }catch(PDOException $ex)
            {
                $return = $this->fncResponse(null, "getSearchRelData");
            }
            echo json_encode($return, http_response_code($return['status']));
            return;
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
                    "total" => count($response),
                    "results" => $response
                ];
            }else
            {
                $json = [
                    "status" =>404,
                    "results" => "Not Found",
                    "error_in" => $method
                ];
            }
            return $json;
        }
    }

?>