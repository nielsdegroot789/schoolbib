<?php 

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header("Content-Type: Application/json");


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

//routes
$app->get('/getBookMeta', \skoolBiep\Controller\BookController::class . ':getBookMeta');

$app->get('/getBooks', \skoolBiep\Controller\BookController::class . ':getBooks');

$app->post('/saveBook', \skoolBiep\Controller\BookController::class . ':saveBook');

$app->run();
 
?> 

