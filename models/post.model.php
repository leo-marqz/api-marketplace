<?php

    require_once("models/database.php");
    class PostModel 
    {

        //===============================================================
        // crear datos apartir de una tabla y sus campos
        //===============================================================
        public static function postData($table, $data)
        {
            $colums = "(";
            $params = "(";
            foreach ($data as $key => $value) {
                $colums .= $key . ",";
                $params .= ":" .$key . ",";
            }
            $colums = substr($colums, 0, -1);
            $params = substr($params, 0, -1);
            
            $colums .= ")";
            $params .= ")";

            $stmt = Database::connect()->prepare("INSERT INTO {$table} {$colums} VALUES {$params}");
            foreach ($data as $key => $value) {
                $stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
            }

            if($stmt->execute())
            {
                return "The process was successful";
            }else
            {
                return Database::connect()->errorInfo();
            }
        }

        //===============================================================
        // obtener nombres de columnas de una tabla 
        //===============================================================

        public static function getColumnsData($table, $database)
        {
            $query = "SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '{$database}' AND table_name = '{$table}' ";
            return Database::connect()->query($query)->fetchAll(PDO::FETCH_OBJ);
        }
    }

?>