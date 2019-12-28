<?php
declare(strict_types=1);


namespace App\Model;
use App\Adapter\DatabaseAdapter;
use PDO;


class Property extends DatabaseAdapter {
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string 
     */
    private $county;

    /**
     * @var string 
     */
    private $country;

    /**
     * @var string
     */
    private $town;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string 
     */
    private $full_details_url;

    /**
     * @var string 
     */
    private $displayable_address;

    /**
     * @var image
     */

    private $image_url;
    /**
     * @var string
     */

    private $thumbnail_url;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float 
     */
    private $longitude;

    /**
     * @var int
     */
    private $number_of_bedrooms;

    /**
     * @var int
     */
    private $number_of_bathrooms;

    /**
     * @var float 
     */
    private $price;

    /**
     * @var int 
     */
    private $property_type_id;

    /**
     * @var string 
     */
    private $property_status;    

    /**
     * @var Database
     */
    private $database;

    public static $FOR_SALE = 1, $FOR_RENT = 0;

    function __construct(string $uuid, string $county, string $country, string $town, string $description, string $displayable_address, string $image_url, int $number_of_bedrooms, int $number_of_bathrooms, float $price, int $property_type_id, int $property_status ) {
        $this->uuid = $uuid;
        $this->county = $county;
        $this->country = $country;
        $this->town  = $town;
        $this->description = $description;
        $this->displayable_address = $displayable_address;
        $this->image_url= $image_url; 
        $this->number_of_bedrooms = $number_of_bedrooms;
        $this->number_of_bathrooms = $number_of_bathrooms;
        $this->price = $price;
        $this->property_type_id = $property_type_id;
        $this->property_status=$property_status;
        $this->database = new DatabaseAdapter();        
    }  
    
    /**
    *Get methods
    */
    function getUuid(): string {
        return $this->uuid;
    }

    function getCounty(): string {
        return $this->county;
    }

    function getCountry(): string {
        return $this->country;
    }

    function getTown(): string {
        return $this->town;
    }
    function getDescription(): string {
        return $this->description;
    }

    function getDisplayable_address(): string {
        return $this->displayable_address;
    }

    function getImage_url(): string {
        return $this->image_url;
    }

    function getNumber_of_bedrooms(): int {
        return $this->number_of_bedrooms;
    } 

    function getNumber_of_bathrooms(): int {
        return $this->number_of_bathrooms;
    }

    function getPrice(): float {
        return $this->price;
    }

    function getProperty_type_id(): int {
        return $this->property_type_id;
    }

    function getProperty_status(): int {
        return $this->property_status;
    }

    

    /**
    *Set methods
    */
    function setUuid(string $uuid): void {
        $this->uuid = $uuid;
    }

    function setCounty(): void {
        $this->county = $county;
    }

    function setCountry(): void {
        $this->country = $country;
    }

    function setTown(): void {
        $this->town = $town;
    }

    function setDescription(): void {
        $this->description = $description;
    }

    function setDisplayable_address(): void {
        $this->displayable_address = $displayable_address;
    }

    function setImage_url(): void {
        $this->image_url = $image_url;
    }

    function setNumber_of_bedrooms(): void {
        $this->number_of_bedrooms = $number_of_bedrooms;
    }

    function setNumber_of_bathrooms(): void {
        $this->number_of_bathrooms = $number_of_bathrooms;
    }

    function setPrice(): void {
        $this->price = $price;
    }

    function setProperty_type_id(): void {
        $this->property_type_id = $property_type_id;
    }

    function setProperty_status(): void {
        $this->property_status = $property_status;
    }

    public function add(): bool {
      try{
            $query = 'INSERT INTO property (uuid, county, country, town, description, displayable_address, image_url, number_of_bedrooms, number_of_bathrooms, price, property_type_id, property_status)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)';
            $params = array($this->uuid, $this->county, $this->country,$this->town, $this->description, 
            $this->displayable_address, $this->image_url, $this->number_of_bedrooms, $this->number_of_bathrooms, $this->price,
            $this->property_type_id, $this->property_status);
            $result = $this->database->query($query, $params);
            if ($result) {
                $this->setUuid($result);
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }

    public function update(): bool {
        $query = "UPDATE property SET county= ? , country= ?, town=?, description=? , displayable_address= ?, image_url=?, number_of_bedrooms=?, number_of_bathrooms=?, price=?, property_type_id= ?, property_status=?
        WHERE uuid =?";
        
        $params = array($this->county, $this->country,$this->town, $this->description, 
        $this->displayable_address, $this->image_url, $this->number_of_bedrooms, $this->number_of_bathrooms, $this->price,
        $this->property_type_id, $this->property_status, $this->uuid);
        
        $result = $this->database->query($query, $params);
        return $result > 0;
    }    

    public function remove(): bool {
        $query = "DELETE FROM property WHERE uuid = ?";
    
        $params = array($this->uuid);
     
        return $this->database->query($query, $params) > 0;
    }    
}
