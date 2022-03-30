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
    }

?>
