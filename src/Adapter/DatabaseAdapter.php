<?php
declare(strict_types=1);
namespace App\Adapter;

use PDO;

// $host = getenv('HOST');
// $port = getenv('PORT');
// $db   = getenv('DATABASE');
// $user = getenv('USERNAME');
// $pass = getenv('PASSWORD');
// define('CONNECTION_STRING', env('CONNECTION_STRING'));
// define('USERNAME', env('USERNAME'));
// define('PASSWORD', env('PASSWORD'));


class DatabaseAdapter {

    const CONNECTION_STRING ="mysql:host=localhost;dbname=property_db"; 
    const USERNAME="root";
    const PASSWORD = "";
  
  private static $dbConn;
  
  private static function refreshDBConnection(){
	  if(isset(self::$dbConn)){
		  self::$dbConn = null;
	  }
	  unset(self::$dbConn);
	  return self::getDBConnection();
  }
  
  private static function getDBConnection(){
	  if(!isset(self::$dbConn)){
		  try {
            self::$dbConn = new PDO(self::CONNECTION_STRING, self::USERNAME, self::PASSWORD);
            self::$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbConn->setAttribute(PDO::ATTR_TIMEOUT, 0);
        } catch (PDOException $ex) {
            //throw $ex; 
        }
	  }
	  return self::$dbConn;
  }

  
  public function getConnection(){
	  return self::getDBConnection();
  }


  public function query($statement, array $params = null, $returnObject = false) {
    try {
      $returnType = PDO::FETCH_ASSOC;
      if ($returnObject) {
          $returnType = PDO::FETCH_OBJ;
      }
      $query = $this->getConnection()->prepare($statement);
      $result = $query->execute($params); 
      if ("i" === trim(substr(strtolower($statement), 0, 1))) {
          return $this->getDBConnection()->lastInsertId();
      }
      if ("s" === trim(substr(strtolower($statement), 0, 1))) {
          return $query->fetchAll(PDO::FETCH_OBJ);

      }
    } catch (PDOException $ex) {
        
      return NULL;
    }//end try
    return $result;
  }
}
