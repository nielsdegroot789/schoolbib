<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
header("Access-Control-Allow-Headers: *");
header("Content-Type: Application/json");

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use skoolBiep\DB;
use skoolBiep\Util\Mailer;
use skoolBiep\Util\ValidateJWT;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

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

$container->set('mailer', function () {
    return new Mailer();
});

$container->set('twig', function () {
    $loader = new FilesystemLoader(__DIR__ . '/../templates');
    return new Environment($loader);
});

$app = AppFactory::create();

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));

$checkLoggedInMW = function ($request, $handler) {
    $authHeader = $request->getHeader('Auth');

    $response = $handler->handle($request);

    if (empty($authHeader)) {
        return $response->withStatus(401);
    }

    $jwtString = $authHeader[0];
    $userId = (new ValidateJWT($jwtString))();

    if (empty($userId)) {
        return $response->withStatus(401);
    }

    // $request->withAttribute('user', $user);
    return $response;
};

// $app->add($checkLoggedInMW);
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//routes
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello ');
    return $response;
})->add($checkLoggedInMW);

//Coockie

setcookie('closeNotif', 'false', time() + (86400 * 30), '/getNotification'); 

// DOES NOT NEED TO BE LOGGED IN

$app->get('/getBookMetaCount', \skoolBiep\Controller\BookController::class . ':getBookMetaCount');
$app->post('/login', \skoolBiep\Controller\UserController::class . ':login');
$app->get('/getNotification', \skoolBiep\Controller\CockpitController::class . ':getNotification');
$app->get('/getCockpitFooterData', \skoolBiep\Controller\CockpitController::class . ':getCockpitFooterData');
$app->post('/resetPassword', \skoolBiep\Controller\UserController::class . ':resetPassword');

$app->get('/getBooks', \skoolBiep\Controller\BookController::class . ':getBooks');
$app->get('/getBookMeta', \skoolBiep\Controller\BookController::class . ':getBookMeta');
$app->get('/getBookMetaFromId', \skoolBiep\Controller\BookController::class . ':getBookMetaFromId');
$app->get('/getFilterResults', \skoolBiep\Controller\BookController::class . ':getFilterResults');
$app->get('/checkToken', \skoolBiep\Controller\UserController::class . ':checkToken');
$app->post('/updatePassword', \skoolBiep\Controller\UserController::class . ':updatePassword');

// NEEDS TO BE LOGGED IN
$app->get('/getReservations', \skoolBiep\Controller\UserController::class . ':getReservations');
$app->get('/getAllUsers', \skoolBiep\Controller\UserController::class . ':getAllUsers');
$app->get('/getCheckouts', \skoolBiep\Controller\UserController::class . ':getCheckouts');
$app->map(['POST', 'DELETE', 'PUT'], '/handleSpecificBook', \skoolBiep\Controller\UserController::class . ':handleSpecificBook');
$app->get('/getAdminSpecificBooks', \skoolBiep\Controller\UserController::class . ':getAdminSpecificBooks');
$app->post('/saveReservationsUser', \skoolBiep\Controller\UserController::class . ':saveReservationsUser');
$app->post('/saveCheckoutAdmin', \skoolBiep\Controller\UserController::class . ':saveCheckoutAdmin');
$app->post('/saveCheckouts', \skoolBiep\Controller\UserController::class . ':saveCheckouts');


$app->get('/getProfilePageData', \skoolBiep\Controller\UserController::class . ':getProfilePageData');

$app->post('/addToFavoriteBookList', \skoolBiep\Controller\UserController::class . ':addToFavoriteBookList');
$app->post('/saveBook', \skoolBiep\Controller\BookController::class . ':saveBook');
$app->post('/saveProfileData', \skoolBiep\Controller\UserController::class . ':saveProfileData');

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, Auth')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
