<?php
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
    $authHeader = $request->getHeader('Authorization');

    $response = $handler->handle($request);

    if (empty($authHeader)) {
        return $response->withStatus(404);
    }

    $jwtString = $authHeader[0];
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
})->add($checkLoggedInMW);

$app->post('/login', \skoolBiep\Controller\UserController::class . ':login');

$app->get('/getBookMeta', \skoolBiep\Controller\BookController::class . ':getBookMeta');

$app->get('/getBooks', \skoolBiep\Controller\BookController::class . ':getBooks');

$app->get('/getNotification', \skoolBiep\Controller\CockpitController::class . ':getNotification');

$app->get('/getProfilePageData', \skoolBiep\Controller\UserController::class . ':getProfilePageData');

$app->get('/getReservation', \skoolBiep\Controller\UserController::class . ':getReservation');

$app->get('/getCheckout', \skoolBiep\Controller\UserController::class . ':getCheckout');

$app->post('/saveReservationsUser', \skoolBiep\Controller\UserController::class . ':saveReservationsUser');

$app->post('/saveCheckoutAdmin', \skoolBiep\Controller\UserController::class . ':saveCheckoutAdmin');

$app->post('/saveBook', \skoolBiep\Controller\BookController::class . ':saveBook');

$app->post('/resetPassword', \skoolBiep\Controller\UserController::class . ':resetPassword');

$app->post('/confirmPasswordReset', \skoolBiep\Controller\UserController::class . ':resetPassword');

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
