<?php
declare(strict_types=1);
namespace App\Repository;

use App\Adapter\DatabaseAdapter;
use App\Adapter\DatabaseRowAdapter;
use App\Model\Property;
use App\Repository\PropertyRepositoryInterface;

class PropertyRepository extends DatabaseRowAdapter implements PropertyRepositoryInterface
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
        $result = $this->database->selectQuery('SELECT * FROM property ORDER by uuid ASC');
        return $this->retrieveAllFromDB($result);
    }

    /**
     * {@inheritdoc}
     */
    public function findPropertyOfUuid(string $uuid): ?Property
    {
        $result = $this->database->selectQuery('SELECT * FROM property  where uuid = "' . $uuid . '"'); 
        return $this->retrieveOneFromDB($result);
    }
    
    public  function retrieveOneFromDB(object $result): ?Property {

        
        while ($row = mysqli_fetch_object($result)) {
            return self::getFromDBRowObject($row);
        }
        return null;
    }

    public static function getFromDBRowObject(object $row): ?Property {
        return new Property($row->uuid, $row->county, $row->country, $row->town, $row->description, $row->displayable_address, $row->image_url, intval($row->number_of_bedrooms), intval($row->number_of_bathrooms), floatval($row->price), intval($row->property_type_id), intval($row->property_status));
    }
}
