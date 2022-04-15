<?php

    class PutModel 
    {

        public static function putData($table, $data, $id, $nameId)
        {
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
                $json = [
                    "status" =>200,
                    "result" => "The process was successful"
                ];
                echo json_encode($json, http_response_code($json['status']));
            }else
            {
                echo Database::connect()->errorInfo();
            }
        }
    }

?> 