<?php

    include("database.php");

    class GetModel 
    {
        public static function getData($table, $orderBy, $orderMode, $startAt, $endAt)
        {
            $query = "SELECT * FROM {$table}";
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
            {
                $query = "SELECT * FROM {$table} ORDER BY {$orderBy} {$orderMode}";
            }else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
            {
                $query = "SELECT * FROM {$table} ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}";
            }
            $stmt = Database::connect()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        /*
         **=============================================================]
         **================> Peticiones GET con filtro <================]
         **=============================================================]
         */
        public static function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode , $startAt, $endAt)
        {
            $query = "SELECT * FROM {$table} WHERE {$linkTo} = :$linkTo";
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                $query = "SELECT * FROM {$table} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode}";
            }else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
            {
                $query = "SELECT * FROM {$table} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}";
            }
            $stmt = Database::connect()->prepare($query);
            $stmt->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        /*
         **=============================================================]
         **===> Peticiones GET entra tablas relacionadas sin filtro <===]
         **=============================================================]
         */
        public static function getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt)
        {
            $relArray = explode(",", $rel);
            $typeArray = explode(",", $type);
            /**
             * Relacion entre dos tablas
             */
            if(count($relArray) == 2 && count($typeArray) == 2)
            {
                $on1 = $relArray[0] . ".id_" . $typeArray[1] . "_" .$typeArray[0];
                $on2 = $relArray[1] . ".id_" . $typeArray[1];
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} ORDER BY {$orderBy} {$orderMode}");
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}");
                }
                else{

                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2}");
                }
            }

            /**=======================>
             * relacion entre 3 tablas
             *========================> 
             */
            if(count($relArray) == 3 && count($typeArray) == 3)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
               
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else{
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b}"
                    );
                }
            }

            /**
             * relacion entre 4 tablas
             */
            if(count($relArray) == 4 && count($typeArray) == 4)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
                
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];
                
                $on3a = $relArray[0] . ".id_" . $typeArray[3] . "_" . $typeArray[0];
                $on3b = $relArray[3] . ".id_" . $typeArray[3];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else{
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b}"
                    );
                }
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        /*
         **=============================================================]
         **===> Peticiones GET entra tablas relacionadas con filtro <===]
         **=============================================================]
         */
        public static function getRelFilterData($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
        {
            $relArray = explode(",", $rel);
            $typeArray = explode(",", $type);
            /**
             * Relacion entre dos tablas
             */
            if(count($relArray) == 2 && count($typeArray) == 2)
            {
                $on1 = $relArray[0] . ".id_" . $typeArray[1] . "_" .$typeArray[0];
                // echo $on1;
                $on2 = $relArray[1] . ".id_" . $typeArray[1];
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode}");
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}");
                }
                else{
                    $stmt = Database::connect()->prepare(
                    "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE {$linkTo} = :$linkTo"
                    );
                }
                $stmt->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR);
            }
            /**
             * relacion entre 3 tablas
             */
            if(count($relArray) == 3 && count($typeArray) == 3)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
               
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo} = :$linkTo"
                    );
                }
                $stmt->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR);
            }

            /**
             * relacion entre 4 tablas
             */
            if(count($relArray) == 4 && count($typeArray) == 4)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
                
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];
                
                $on3a = $relArray[0] . ".id_" . $typeArray[3] . "_" . $typeArray[0];
                $on3b = $relArray[3] . ".id_" . $typeArray[3];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo} = :$linkTo ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo} = :$linkTo"
                    );
                }
                $stmt->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        /*
         **=============================================================]
         **==============> Peticiones GET para busquedas <==============]
         **=============================================================]
         */

        public static function getSearchData($table, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
        {
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
            {
                $stmt = Database::connect()->prepare("SELECT * FROM {$table} WHERE {$linkTo} LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode}");
            }
            else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
            {
                $stmt = Database::connect()->prepare("SELECT * FROM {$table} WHERE {$linkTo} LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt} ");
            }
            else
            {
                $stmt = Database::connect()->prepare("SELECT * FROM {$table} WHERE {$linkTo} LIKE '%{$search}%'");
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } 


        /*
         **=============================================================]
         **==============> Peticiones GET para busquedas entre tablas relacionadas <==============]
         **=============================================================]
         */
        public static function getSearchRelData($rel, $type, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
        {
            $relArray = explode(",", $rel);
            $typeArray = explode(",", $type);
            /**
             * Relacion entre dos tablas
             */
            if(count($relArray) == 2 && count($typeArray) == 2)
            {
                $on1 = $relArray[0] . ".id_" . $typeArray[1] . "_" .$typeArray[0];
                $on2 = $relArray[1] . ".id_" . $typeArray[1];
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE {$linkTo}  LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode}");
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE {$linkTo}  LIKE '%{$search}%'  ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}");
                }
                else{
                    $stmt = Database::connect()->prepare("SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1} = {$on2} WHERE  {$linkTo}  LIKE '%{$search}%' ");
                }
                $stmt->bindParam(":" . $linkTo, $search, PDO::PARAM_STR);
            }
            /**
             * relacion entre 3 tablas
             */
            if(count($relArray) == 3 && count($typeArray) == 3)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
               
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo}  LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo}  LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} WHERE {$linkTo}  LIKE '%{$search}%'"
                    );
                }
                $stmt->bindParam(":" . $linkTo, $search, PDO::PARAM_STR);
            }

            /**
             * relacion entre 4 tablas
             */
            if(count($relArray) == 4 && count($typeArray) == 4)
            {
                $on1a = $relArray[0] . ".id_" . $typeArray[1] . "_" . $typeArray[0];
                $on1b = $relArray[1] . ".id_" . $typeArray[1];
                
                $on2a = $relArray[0] . ".id_" . $typeArray[2] . "_" . $typeArray[0];
                $on2b = $relArray[2] . ".id_" . $typeArray[2];
                
                $on3a = $relArray[0] . ".id_" . $typeArray[3] . "_" . $typeArray[0];
                $on3b = $relArray[3] . ".id_" . $typeArray[3];

                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo}  LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode}"
                    );
                }
                else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null)
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo}  LIKE '%{$search}%' ORDER BY {$orderBy} {$orderMode} LIMIT {$startAt}, {$endAt}"
                    );
                }
                else
                {
                    $stmt = Database::connect()->prepare(
                        "SELECT * FROM {$relArray[0]} INNER JOIN {$relArray[1]} ON {$on1a} = {$on1b} INNER JOIN {$relArray[2]} OM {$on2a} = {$on2b} INNER JOIN {$relArray[3]} ON {$on3a} = {$on3b} WHERE {$linkTo}  LIKE '%{$search}%'"
                    );
                }
                $stmt->bindParam(":" . $linkTo, $search, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }


    }

?>


