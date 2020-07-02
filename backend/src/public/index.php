<?php 
use Psr\Http\Message\ResponseInterface as Response;                                       
use Psr\Http\Message\ServerRequestInterface as Request; 

use Slim\Factory\AppFactory;
use DI\Container;
use \Slim\Views\Twig;
use \Slim\Views\TwigMiddleware; 
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

$app = AppFactory::create(); 

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));

$app->map(['GET', 'POST'], '/login', \skoolBiep\Controller\UserController::class . ':login');

$app->map(['GET', 'POST'], '/create', \skoolBiep\Controller\UserController::class . ':create');


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

$app->run();
 
?> 

