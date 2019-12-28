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
