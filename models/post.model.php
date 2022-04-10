<?php

    require_once("models/database.php");
    class PostModel 
    {

        //===============================================================
        // crear datos apartir de una tabla y sus campos
        //===============================================================
        public static function postData($table, $data)
        {
            // $query = "INSERT INTO {$table} ";
            // $stmt = Database::connect()->prepare("");
            // $stmt->execute();

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