<?php
declare(strict_types=1);

namespace App\Model;
use App\Adapter\DatabaseAdapter;

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
        $this->displayable_addresss = $displayable_address;
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
    function setUuid(int $uuid): void {
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
        $this->displayable_address = $displayable_addresss;
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
        $query = 'INSERT INTO property (uuid, county, country, town, description, displayable_address, image_url, number_of_bedrooms, number_of_bathrooms, price, property_type_id, property_status)'
        . ' VALUES("' . $this->database->fliter($this->uuid) . '", "' . $this->database->fliter($this->county) . '",
        "' . $this->database->fliter($this->country) . '", "' . $this->database->fliter($this->town) . '",
        "' . $this->database->fliter($this->description) . '", "' . $this->database->fliter($this->displayable_addresss) . '",
        "' . $this->database->fliter($this->image_url) . '", ' . intval($this->number_of_bedrooms) . ',
        ' . intval($this->number_of_bathrooms) . ', ' . floatval($this->price) . ',
        ' . intval($this->property_type_id) . ', ' . intval($this->property_status) . ')';
        $result = $this->database->query($query);
        if ($result > 0) {
            $this->setUuid($result);
            return true;
        }
        return false;
    }

    public function update(): bool {
        $query = 'UPDATE property set county = "' . $this->database->fliter($this->county) . '",
        country = "' . $this->database->fliter($this->country) . '",
        town = "' . $this->database->fliter($this->town) . '",
        description = "' . $this->database->fliter($this->description) . '",
        displayable_address =  "' . $this->database->fliter($this->displayable_addresss) . '",
        image_url = "' . $this->database->fliter($this->image_url) . '",
        number_of_bedrooms = ' . intval($this->number_of_bedrooms) . ',
        number_of_bathrooms = ' . intval($this->number_of_bathrooms) . ',
        price = ' . floatval($this->price) . ',
        property_type_id = ' . intval($this->property_type_id) . ',
        property_status = ' . intval($this->property_status) . ' 
        where uuid = "' . $this->database->fliter($this->uuid) . '"';
        return $this->database->query($query) > 0;
    }    

    public function remove(): bool {
        $query = 'DELETE FROM property where uuid = "' . $this->database->fliter($this->uuid) . '"';
        return $this->database->query($query) > 0;
    }    
}
?>