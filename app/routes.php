<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Model\Property;
use App\Model\PropertyType;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
  
  $app->get('/', function (Request $request, Response $response) {
    //$api_url = "http://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[1]&page[100]";

    // function getData($api_url){
    //   $jsonContent = file_get_contents($api_url);
    //   $mydata = json_decode($jsonContent, true);
    //   $properties = $mydata['data'];
    //   if(isset($mydata['next_page_url']) && $mydata['next_page_url'] !== null){
    //       $properties = $mydata['data'];
    //       $properties = array_merge($properties,(getData($mydata['next_page_url'])));
    //   }
    //   return $properties;
    // }
      
      //print_r (getData($api_url));
    //   $properties = getData($api_url);
    //   $countprop = count($properties);
    $repository = new PropertyRepository();
    $repositoryType = new PropertyTypeRepository();
    //   foreach($properties as $prop){    
    //     $property = new Property($prop['uuid'], $prop['county'], $prop['country'], $prop['town'], $prop['description'], $prop['address'], $prop['image_full'], intval($prop['num_bedrooms']), intval($prop['num_bathrooms']), floatval($prop['price']), intval($prop['property_type_id']), $prop['type'] == 'sale' ? Property::$FOR_SALE : Property::$FOR_RENT);
    //     $result = !$repository->findPropertyOfUuid($prop['uuid']) ? $property->add() : $property->update();
    //     $propertyTypeFromArray = $prop['property_type'];
    //     $propertyType = new PropertyType(intval($propertyTypeFromArray['id']), $propertyTypeFromArray['title'], $propertyTypeFromArray['description']);
    //     $result = !$repositoryType->findPropertyTypeOfId($propertyTypeFromArray['id']) ? $propertyType->add() : $propertyType->update();
    //     $property_status = $prop['type'] == 'sale' ? Property::$FOR_SALE : Property::$FOR_RENT;
    //   }  
      $properties = $repository->findAll();
       //var_dump($properties); exit;
      $propertyTpes = $repositoryType->findAll();
      return $this->get('view')->render($response, 'index.twig', [
        "properties" => $properties,
        "propertyTpes" => $propertyTpes,
      ]);    
  });

	$app->get('/delete/{uuid}', function (Request $request, Response $response, $args) {
		$repository = new PropertyRepository();
		$property = $repository->findPropertyOfUuid( $args['uuid']);
		if ($property) $property->remove();
		return $response->withHeader('Location', '/')->withStatus(302);
	});

	$app->post('/add', function (Request $request, Response $response, $args) {
		$uuid = md5(uniqid(rand().'', true));
		$property =  new Property($uuid, $request->getParsedBody()['county'], $request->getParsedBody()['country'], $request->getParsedBody()['town'], $request->getParsedBody()['description'], $request->getParsedBody()['displayable_addresss'],$request->getParsedBody()['image_url'], intval($request->getParsedBody()['number_of_bedrooms']), intval($request->getParsedBody()['number_of_bathrooms']), floatval($request->getParsedBody()['price']), intval($request->getParsedBody()['property_type_id']), intval($request->getParsedBody()['property_status']));
    $property->add();
		return $response->withHeader('Location', '/')->withStatus(302);
	});
  
  $app->post('/edit/{uuid}', function (Request $request, Response $response, $args) {
    //$uuid = md5(uniqid(rand().'', true));
    $repository = new PropertyRepository();
		$property = $repository->findPropertyOfUuid( $args['uuid']);
    if($property) $property->update();
    
		return $response->withHeader('Location', '/')->withStatus(302);
	});
};
