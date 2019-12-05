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

}
