<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as psr7Response;
use skoolBiep\DB;
use skoolBiep\Util\Mailer;
use skoolBiep\Util\ValidateJWT;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Slim\Exception\NotFoundException;


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

//LoggedInAsAdmin/arch
$checkLoggedInAdminArchMW = function ($request, $handler) {
    $authHeader = $request->getHeader('Auth');
    if (empty($authHeader)) {
        $response = new psr7Response();
        return $response->withStatus(401);
    }
    
    $jwtString = $authHeader[0];
    try{
        $jwtValidator = new ValidateJWT($jwtString);
        $userId = $jwtValidator->getUserId();
        $role = $jwtValidator->getUserRole();
    } catch(Exception $e){
        $response = new psr7Response();
        $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
        return $response->withStatus(401);
    }

    //Check that student does not access admin stuff
    if(!($role == 2 || $role == 3)){
        $response = new psr7Response();
        return $response->withStatus(401);
    }
    
    if (empty($userId)) {
        $response = new psr7Response();
        return $response->withStatus(401);
    }
    
    $response = $handler->handle($request);
    // $request->withAttribute('user', $user);
    return $response;
};

// Basic logged in middleware
$checkLoggedInMW = function ($request, $handler) {
    $authHeader = $request->getHeader('Auth');
    if (empty($authHeader)) {
        $response = new psr7Response();
        return $response->withStatus(401);
    }
    
    try{
        $jwtValidator = new ValidateJWT($jwtString);
        $userId = $jwtValidator->getUserId();
    } catch(Exception $e){
        $response = new psr7Response();
        $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
        return $response->withStatus(401);
    }
   
    if (empty($userId)) {
        $response = new psr7Response();
        return $response->withStatus(401);
    }
    
    $response = $handler->handle($request);
    // $request->withAttribute('user', $user);
    return $response;
};

// $app->add($checkLoggedInMW);
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

// DOES NOT NEED TO BE LOGGED IN
$app->get('/executeCronJob', \skoolBiep\Util\CronJob::class . ':start');
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
$app->get('/stockCount', \skoolBiep\Controller\BookController::class . ':stockCount');


// NEEDS TO BE LOGGED IN
$app->group('/', function () use ($app) {
    $app->post('/saveReservationsUser', \skoolBiep\Controller\UserController::class . ':saveReservationsUser');
    $app->get('/getFavoriteAuthors', \skoolBiep\Controller\UserController::class . ':getFavoriteAuthors');
    $app->get('/getFavoriteBooks', \skoolBiep\Controller\UserController::class . ':getFavoriteBooks');
    $app->get('/getCheckoutUser', \skoolBiep\Controller\UserController::class . ':getCheckoutUser');
    $app->get('/getReservationUser', \skoolBiep\Controller\UserController::class . ':getReservationUser');
    $app->delete('/deleteFavoriteAuthors', \skoolBiep\Controller\UserController::class . ':deleteFavoriteAuthors');
    $app->delete('/deleteFavoriteBooks', \skoolBiep\Controller\UserController::class . ':deleteFavoriteBooks');
    $app->delete('/deleteReservationUser', \skoolBiep\Controller\UserController::class . ':deleteReservationUser');
    $app->get('/getProfilePageData', \skoolBiep\Controller\UserController::class . ':getProfilePageData');
    $app->post('/addToFavoriteBookList', \skoolBiep\Controller\BookController::class . ':addToFavoriteBookList');
    $app->post('/saveProfileData', \skoolBiep\Controller\UserController::class . ':saveProfileData');
})->add($checkLoggedInMW);

$app->group('/', function () use ($app) {
    $app->post('/saveCheckoutAdmin', \skoolBiep\Controller\UserController::class . ':saveCheckoutAdmin');
    $app->post('/saveCheckouts', \skoolBiep\Controller\UserController::class . ':saveCheckouts');
    $app->get('/getAdminSpecificBooks', \skoolBiep\Controller\UserController::class . ':getAdminSpecificBooks');
    $app->map(['POST', 'DELETE', 'PUT'], '/handleSpecificBook', \skoolBiep\Controller\UserController::class . ':handleSpecificBook');
    $app->get('/getCheckouts', \skoolBiep\Controller\UserController::class . ':getCheckouts');
    $app->get('/getAllUsers', \skoolBiep\Controller\UserController::class . ':getAllUsers');
    $app->get('/getReservations', \skoolBiep\Controller\UserController::class . ':getReservations');
    $app->delete('/deleteBookMeta', \skoolBiep\Controller\BookController::class . ':deleteBookMeta'); 
    $app->post('/saveBook', \skoolBiep\Controller\BookController::class . ':saveBook');
})->add($checkLoggedInAdminArchMW);


$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Auth')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
