<?php
declare(strict_types=1);

namespace App\Model;
use App\Adapter\DatabaseAdapter;
use PDO;

class PropertyType {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;
    
    /**
     * @var string
     */
    private $description;

	
	function __construct(int $id, string $title, string $description) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->database = new DatabaseAdapter();        
    }


    /**
    *get methods to access class parameters
    */
    function getId(): int {
        return $this->id;
    }

    function getTitle(): string {
        return $this->title;
    }

    function getDescription(): string {
        return $this->description;
    }
   
    /**
    *Set methods
    */
    function setId(int $id): void {
        $this->id = $id;
    }

    function setTitle(string $title): void {
        $this->title = $title;
    }

    function setDescription(string $description): void {
        $this->description = $description;
    }

    public function add(): bool {
        $query = "INSERT INTO `property_type` (id, `title`, `description`) VALUES (?, ?,?)";
        $params = array($this->id,  $this->title, $this->description);
        $result = $this->database->query($query, $params);
        if ($result > 0) {
            $this->setId((int)$result);
            return true;
        }
        return false;
    }

    public function update(): bool {
        $query = "UPDATE property_type SET title = ?, description=? WHERE id= ?";
        $params = array($this->title, $this->description, $this->id);
        $result = $this->database->query($query, $params);
        return $result>0;
    }    


}