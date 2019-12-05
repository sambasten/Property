<?php
declare(strict_types=1);

namespace App\Model;
use App\Adapter\DatabaseAdapter;

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
        $query = 'INSERT INTO property_type (id, title, description)'
        . ' VALUES(' . intval($this->id) . ', "' . $this->database->fliter($this->title) . '",
        "' . $this->database->fliter($this->description) . '")';
        $result = $this->database->query($query);
        if ($result > 0) {
            $this->setId($result);
            return true;
        }
        return false;
    }

    public function update(): bool {
        $query = 'UPDATE property_type set title = "' . $this->database->fliter($this->title) . '",
        description = "' . $this->database->fliter($this->description) . '"
        where id = ' . intval($this->id) ;
        return $this->database->query($query) > 0;
    }    


}