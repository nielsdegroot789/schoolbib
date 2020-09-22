<?php

// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
// header("Access-Control-Allow-Headers: *");
// header("Content-Type: Application/json");

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



$mw = function ($request, $handler) {
  // $headers = $request->headers;
  $secret = "ABC";
  $JWTtoken = $request->getHeader('Authorization');
  $explodedToken = explode('.', $JWTtoken[0]);
  $incomingHeader  = $explodedToken[0];
  $incomingPayload  = $explodedToken[1];
  $incomingSignature =  $explodedToken[2];

  $signature = hash_hmac('sha256', $incomingHeader. '.' . $incomingPayload, $secret, true);
  $base64UrlSignature  =str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  if($base64UrlSignature == $incomingSignature)
  {
    //great success, access granted
    var_dump("test succeeded");
  }
  else {
    //redirect to login screen
    var_dump("test failed");
  }

  $response = $handler->handle($request);
  // $response->getBody()->write('World');

  return $response;
};

$app->add($mw);


//routes
// $app->get('/', function (Request $request, Response $response, array $args) {
//   $response->getBody()->write("Hello");
//   return $response;
// })->add($$checkLoggedInMW);

$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write('Hello ');

  return $response;
})->add($mw);

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
