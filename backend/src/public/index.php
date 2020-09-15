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

//routes
$app->get('/getBookMeta', \skoolBiep\Controller\BookController::class . ':getBookMeta');

$app->get('/getBooks', \skoolBiep\Controller\BookController::class . ':getBooks');

$app->get('/getNotification',\skoolBiep\Controller\CockpitController::class . ':getNotification');

  
// $app->map(['GET', 'POST'], '/create', function (Request $request, Response $response, array $args) {
//     $this->get('db');
//     if ($request->getMethod() == 'GET') {
//         $html = '<h1>Login</h1>
// <form method="POST"><label for="username">Username:</label><input type="text" size="40" name="username" /><br />';
//         $html = $html . '<label for="password">Password:</label><input type="password" size="40" name="password" /><br />';
//         $html = $html . '<input type="submit" value="Create user" name="Save" /></form>';
//         $response->getBody()->write($html);
//     } else {
//         // verwerking form
//         $user = new User();
//         $user->setUserName($request->getParsedBody()['username']);
//         $id = $user->saveUser($request->getParsedBody()['password']);
//         echo "User received ID: $id";
//     }
//     return $response;
// });
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
