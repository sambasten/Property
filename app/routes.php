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
		$repository = new PropertyRepository();
		$repositoryType = new PropertyTypeRepository();
		$properties = $repository->findAll();
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
		return $response->withHeader('Location', '/')->withStatus(302);
	});
};
