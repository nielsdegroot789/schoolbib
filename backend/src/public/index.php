<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
header("Access-Control-Allow-Headers: *");
header("Content-Type: Application/json");

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use skoolBiep\DB;
use skoolBiep\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as psr7Response;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$container->set('db', function () {
  return new DB();
});

$container->set('view', function () {
  return Twig::create('../templates');
});

$container->set('client', function () {
  return new GuzzleHttp\Client();
});

$app = AppFactory::create(); 

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));



$checkLoggedInMW = function ($request, $handler) {
  $authHeader = $request->getHeader('Authorization');
  $response = new Response($handler->handle($request), new StreamFactory());

  if (empty($authHeader)) {
      return $response->withStatus(404);
  }

  $jwtString = substr($authHeader[0], 7);
  $userId = (new ValidateJWT($jwtString))();

  if (empty($userId)) {
    return $response->withStatus(404);
  }

  //todo ??
  // $request->withAttribute('user', $user);
  return $response;
};

// $app->add($checkLoggedInMW);


//routes
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write('Hello ');

  return $response;
});

$app->post('/login', \skoolBiep\Controller\UserController::class . ':login');

$app->get('/getBookMeta', \skoolBiep\Controller\BookController::class . ':getBookMeta');

$app->get('/getBooks', \skoolBiep\Controller\BookController::class . ':getBooks');

$app->get('/getNotification',\skoolBiep\Controller\CockpitController::class . ':getNotification');

$app->post('/saveBook', \skoolBiep\Controller\BookController::class . ':saveBook');

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
          ->withHeader('Access-Control-Allow-Origin', '*')
          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
          ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
?>
