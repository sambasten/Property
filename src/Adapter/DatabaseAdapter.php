<?php
declare(strict_types=1);
namespace App\Adapter;

use PDO;

class DatabaseAdapter {

    const CONNECTION_STRING ="mysql:host=localhost;dbname=property_db"; 
    const USERNAME="root";
    const PASSWORD = "";
    private $connection;

    public function __construct() {
        $this->openConnection();

    }


    public function openConnection(){
   
      if (!isset($this->connection)) {
        try {
            $this->connection= new PDO(self::CONNECTION_STRING, self::USERNAME, self::PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
    }

    public function query($statement, array $params = null, $returnObject = false) {
    
      try {
          
          $returnType = PDO::FETCH_ASSOC;
          if ($returnObject) {
              $returnType = PDO::FETCH_OBJ;
          }
          $query = $this->connection->prepare($statement);
          $result = $query->execute($params); 
          if ("i" === trim(substr(strtolower($statement), 0, 1))) {
              return $this->connection->lastInsertId();
          }
          if ("s" === trim(substr(strtolower($statement), 0, 1))) {
              return $query->fetchAll(PDO::FETCH_OBJ);

          }
      } catch (PDOException $ex) {
         
        return NULL;
      }//end try
      return $result;
  }

    public function getConnection(): object {
        return $this->connection;
        

    }

}

?>