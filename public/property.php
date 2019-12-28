<?php

require __DIR__ . '/../vendor/autoload.php';
use App\Model\Property;
use App\Model\PropertyType;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;

    function getData($api_url){
      $jsonContent = file_get_contents($api_url);
      $mydata = json_decode($jsonContent, true);
      $properties = $mydata['data'];
      if(isset($mydata['next_page_url']) && $mydata['next_page_url'] !== null){
          $properties = $mydata['data'];
          $properties = array_merge($properties,(getData($mydata['next_page_url'])));
      }
      return $properties;
    }

    function processData($properties){
      $repository = new PropertyRepository();
      $repositoryType = new PropertyTypeRepository();
      foreach($properties as $prop){    
        $property = new Property($prop['uuid'], $prop['county'], $prop['country'], $prop['town'], $prop['description'], $prop['address'], $prop['image_full'], intval($prop['num_bedrooms']), intval($prop['num_bathrooms']), floatval($prop['price']), intval($prop['property_type_id']), $prop['type'] == 'sale' ? Property::$FOR_SALE : Property::$FOR_RENT);
        $result = !$repository->findPropertyOfUuid($prop['uuid']) ? $property->add() : $property->update();
        $propertyTypeFromArray = $prop['property_type'];
        $propertyType = new PropertyType(intval($propertyTypeFromArray['id']), $propertyTypeFromArray['title'], $propertyTypeFromArray['description']);
        $result = !$repositoryType->findPropertyTypeOfId($propertyTypeFromArray['id']) ? $propertyType->add() : $propertyType->update();
        $property_status = $prop['type'] == 'sale' ? Property::$FOR_SALE : Property::$FOR_RENT;
      }
    }
    $api_url = "http://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[1]&page[100]";
    $properties = getData($api_url);
    processData($properties);
    echo "properties added to database \n";
    echo "change directory to property and \n";
    echo "run command > php -S localhost:8080 -t public";

?>