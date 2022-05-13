<?php

    class DeleteModel 
    {
        public static function deleteData($table, $id, $nameId)
        {
            $return = null;
            $query = "DELETE FROM {$table} WHERE {$nameId} = :{$nameId}";
            $stmt = Database::connect()->prepare($query);
            $stmt->bindParam(":".$nameId, $id, PDO::PARAM_INT);
            if($stmt->execute())
            {
                $return = "The process was successful";
            }
            else 
            {
                echo Database::connect()->errorInfo();
            }
            return $return;
        }
    }

?>