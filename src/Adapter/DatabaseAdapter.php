<?php
declare(strict_types=1);

namespace App\Adapter;

class DatabaseAdapter {

    // mysql connection parameters
    private static $HOST = "localhost";
    private static $USER = "root";
    private static $PASS = "";
    private static $DATABASE = "property_db";
    private $connection;

    public function __construct() {
        $this->setConnection();
    }

    // function to create connection
    public function setConnection(): void {
        $this->connection = mysqli_connect(self::$HOST, self::$USER, self::$PASS, self::$DATABASE);
    }

    public function getConnection(): object {
        return $this->connection;
    }

    // function to procees query
    public function selectQuery(string $statement): ?object {
        return mysqli_query($this->connection, $statement);        
    }
    // function to procees query
    public function query(string $statement): ?int {
        $query = mysqli_query($this->connection, $statement);

        if (!$query) {
           die(mysqli_error($this->connection));
        } else {
            if (strtolower(substr(trim($statement), 0, 1)) == "i") {
                return mysqli_insert_id($this->connection);
            } elseif (strtolower(substr(trim($statement), 0, 1)) == "s") {
                return $query;
            } elseif (strtolower(substr(trim($statement), 0, 1)) == "u") {
                return 1;
            } else {
                return null;
            }
        }
    }

    
    //function to filer string in mysqli
    public function fliter( string $statement): string {
        return mysqli_escape_string($this->connection, $statement);      
    }

    public function __destruct() {
        //$this->connection->close();
    }

}

?>