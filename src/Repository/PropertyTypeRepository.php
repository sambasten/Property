<?php
declare(strict_types=1);
namespace App\Repository;

use App\Adapter\DatabaseAdapter;
use App\Adapter\DatabaseRowAdapter;
use App\Model\PropertyType;
use App\Repository\PropertyTypeRepositoryInterface;
use PDO;

class PropertyTypeRepository extends DatabaseRowAdapter implements PropertyTypeRepositoryInterface
{
    /**
     * @var Database
     */
    private $database;

    /**
     * PropertyRepository constructor.
     */
    public function __construct()
    {
        $this->database = new DatabaseAdapter();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $properties = array();
        $result = $this->database->query('SELECT * FROM property_type ORDER by id ASC');
        return $this->retrieveAllFromDB($result);
    }

    /**
     * {@inheritdoc}
     */
    public function findPropertyTypeOfId(int $id): ?PropertyType
    {
        $result = $this->database->query('SELECT * FROM property_type  where id =  ?', array($id));
        return $this->retrieveOneFromDB($result);
    }
    
    public  function retrieveOneFromDB(array $result): ?PropertyType {
        foreach( $result as  $row) {
            return self::getFromDBRowObject($row);
        }
        return null;
    }

    public static function getFromDBRowObject(object $row): ?PropertyType {
        return new PropertyType(intval($row->id), $row->title, $row->description);
    }


}
