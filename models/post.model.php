<?php

    require_once("models/database.php");
    class PostModel 
    {
        public static function postData($table, $data)
        {
            $query = "INSERT INTO {$table} ";
            $stmt = Database::connect()->prepare("");
            $stmt->execute();

        }
    }

?>