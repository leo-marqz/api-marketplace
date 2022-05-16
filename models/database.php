<?php

    class Database 
    {
        /**
         * @author LeoMarqz
         * @return PDO|null
         */
        public static function connect()
        {
            $link = null;
            try
            {
                $link = new PDO("mysql:host=localhost;dbname=app_marketplace", "root", "");
                $link->exec("set names utf8");

            }catch(PDOException $ex)
            {
                die("Error en la conexion a la base de datos: --> " . $ex->getMessage() );
            }
            return $link;
        }

    }

?>
