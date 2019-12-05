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
		$response->getBody()->write('Hello world!');
		return $response;
	});

	$app->get('/api/properties', function (Request $request, Response $response) {
		$jsonContent = file_get_contents('http://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug');
		$data = json_decode($jsonContent);
		$repository = new PropertyRepository();
		$repositoryType = new PropertyTypeRepository();
		$properties = $data->data;

		for ($i = 0; $i < count($properties); $i++) {
			$propertyTypeFromJSON = $properties[$i]->property_type;
			$propertyType = new PropertyType(intval($propertyTypeFromJSON->id), $propertyTypeFromJSON->title, $propertyTypeFromJSON->description);
			$result = !$repositoryType->findPropertyTypeOfId($propertyTypeFromJSON->id) ? $propertyType->add() : $propertyType->update();
			$property_status = $properties[$i]->type == 'sale' ? Property::$FOR_SALE : Property::$FOR_RENT;
			$property = new Property($properties[$i]->uuid, $properties[$i]->county, $properties[$i]->country, $properties[$i]->town, $properties[$i]->description, $properties[$i]->address, $properties[$i]->image_full, intval($properties[$i]->num_bedrooms), intval($properties[$i]->num_bathrooms), floatval($properties[$i]->price), intval($properties[$i]->property_type_id), $property_status);
			$result = !$repository->findPropertyOfUuid($properties[$i]->uuid) ? $property->add() : $property->update();

		}      
		return true;
	});
};
