<?php
declare(strict_types=1);

namespace App\Adapter;

abstract class DatabaseRowAdapter {
 
    public function retrieveAllFromDB(object $result): ?array {
        $data = array();
         while ($row = mysqli_fetch_object($result)) {
           $data[] = self::getFromDBRow($row);
        }
        return $data;
    }

    public static function getFromDBRow($row) {
        $className = get_called_class();
        if (is_object($row))
            return call_user_func($className . "::getFromDBRowObject", $row);
        if (is_array($row))
            return call_user_func($className . "::getFromDBRowArray", $row);
    }
}
