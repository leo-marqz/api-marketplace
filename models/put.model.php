<?php

    class PutModel 
    {

        public static function putData($table, $data, $id, $nameId)
        {
            $response = null;
            $set = "";
            foreach ($data as $key => $value) 
                $set .= $key . " = :" . $key . ",";
                    
            $set = substr($set, 0, -1);

            // echo "UPDATE {$table} SET {$set} WHERE {$nameId} = :{$nameId}";
            $stmt = Database::connect()->prepare("UPDATE {$table} SET {$set} WHERE {$nameId} = :{$nameId}");
            foreach ($data as $key => $value) 
            {
                $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
            }
            $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_INT);
            if($stmt->execute())
            {
                $response = "The process was successful";
            }
            // else
            // {
            //     // echo Database::connect()->errorInfo();
            //     $response = null;
            // }
            return $response;
        }
    }

?> 