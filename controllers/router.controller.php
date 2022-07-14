<?php
    class RoutesController
    {
        /**
         * @Route Main
         */
        public function index()
        {
            require_once("routes/route.php");
        }

        /**
         * @dbname
         */

         public static function database()
         {
             return "app_marketplace";
         }
    }

?>
