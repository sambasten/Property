<?php
declare(strict_types=1);

namespace App\Adapter;
use PDO;


abstract class DatabaseRowAdapter {
 
    public function retrieveAllFromDB(array $result): ?array {
        $data = array();
         foreach ($result as $row) {
           $data[] = self::getFromDBRow($row);
        }
        return $data;
    }

    public static function getFromDBRow($row) {
        $className = get_called_class();
        if (is_object($row))
            return call_user_func($className . "::getFromDBRowObject", $row);
    }
}
