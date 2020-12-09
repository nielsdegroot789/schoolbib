<?php

namespace skoolBiep\Controller;


use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use skoolBiep\Entity\User;
use skoolBiep\Util\CreateJWT;
use skoolBiep\DB;

$data = array();
class UserController
{
    private $user;
    protected $container;
    protected $response;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $formEmail = $data["email"];
            if (!$formEmail) {
                throw new Exception('Email not filled in correctly');
            }

            $formPassword = $data["password"];
            if (!$formPassword) {
                throw new Exception('Password not filled in correctly');
            }

        } catch (Exception $e) {
            $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
            return $response->withStatus(401);
        }

        try {
            $user = $this->validateUser($formEmail, $formPassword);
            $jwt = new CreateJWT($user);
            $token = $jwt();

            $response->getBody()->write($token);
            return $response->withHeader('Authorization', 'Bearer: ' . $token);
        } catch (Exception $e) {
            $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
            return $response->withStatus(401);
        }
    }

    public function validateUser(String $formEmail, String $formPassword): array
    {
        $user = null;

        $db = $this->container->get('db');
        $user = $db->getUserByEmail($formEmail);
        if ($user) {
            if (password_verify($formPassword, $user['password'])) {
                $this->setUser($user);
                return $user;
            }
        }

        throw new Exception("Combination not found");
    }

    public function resetPassword(Request $request, Response $response, array $args)
    {
        try{
            $data = json_decode(file_get_contents("php://input"), true);
            $db = $this->container->get('db');
            $address = $data["email"];
            $token = $db->checkAdress($address);
            
            if(!$token) {
                throw new Exception('Email is not registered');
            }
            $body = $this->container->get('twig')->render('twig.twig', ['token' => $token]);
            $subject = "Password reset";
            $this->container->get('mailer')->sendMail($address, $body, $subject);
            return $response;
        }
        catch(Exception $e){
            $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
            return $response->withStatus(401);
        }
    }

    public function setUser(array $user)
    {
        $this->user = $user;
    }
    public function getUser(): array
    {
        return $this->user;
    }

    public function addToFavoriteBookList(Request $request, Response $response, array $args)
    {            
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $usersId = $data["usersId"];
        $bookMetaId = $data["bookMetaId"];
        

        if($data['id']){
            $id = $data['id'];
            $data = $db->addToFavoriteBookList($usersId, $bookMetaId);
        }
        else {
            $data = $db->addToFavoriteBookList($usersId, $bookMetaId);
        }
        $response->getBody()->write($data);
        return $response;
    }

    public function saveReservationsUser(Request $request, Response $response, array $args)
    {            
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $usersId = $data["usersId"];
        $booksId = $data["booksId"];
        $reservationDateTime = $data["reservationDateTime"];
        $accepted = 1;

        if($data['id']){
            $id = $data['id'];
            $data = $db->saveReservationsUser($usersId, $booksId, $reservationDateTime, $accepted);
        }
        else {
            $data = $db->saveReservationsUser($usersId, $booksId, $reservationDateTime, $accepted);
        }
        $response->getBody()->write($data);
        return $response;
    }

    public function saveCheckouts(Request $request, Response $response, array $args)
    {            
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $usersId = $data["usersId"];
        $booksId = $data["booksId"];
        $checkoutDateTime = $data["checkoutDateTime"];
        $returnDateTime = $data["reservationDateTime"];
        $maxAllowedDate = $data["maxAllowedDate"];
        $fine = $data["fine"];
        $isPaid = $data["isPaid"];     
        $data = $db->saveCheckouts($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate, $fine, $isPaid);
      
        $response->getBody()->write($data);
        return $response;
    }
    public function saveNewCheckout(Request $request, Response $response, array $args)
    {            
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $usersId = $data["usersId"];
        $booksId = $data["booksId"];
        $checkoutDateTime = $data["checkoutDateTime"];
        $returnDateTime = $data["reservationDateTime"];
        $maxAllowedDate = $data["maxAllowedDate"];
        if($data['id']){
            $id = $data['id'];
            $data = $db->saveNewCheckout($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate);
        }
        else {
            $data = $db->saveNewCheckout($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate);
        }
        $response->getBody()->write($data);
        return $response;
    }


    public function getReservations(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $arguments = json_decode(file_get_contents("php://input"), true);
        $id = isset($arguments["id"]) ? '%' . $arguments["id"] : "%";
        $usersId = isset($arguments["usersId"]) ? '%' . $arguments["usersId"] : "%";
        $booksId = isset($arguments["booksId"]) ? $arguments["booksId"] : "%";
        $reservationDateTime = isset($arguments["reservationDateTime"]) ? '%' .$arguments["reservationDateTime"] :"%";
        $accepted = isset($arguments["accepted"]) ? '%' .$arguments["accepted"] : "%";
        $limitNumber = isset($arguments["limit"]) ? $arguments["limit"] : 20;
        $offsetNumber = isset($arguments["offset"]) ? $arguments["offset"] : 0;


        $data = $db->getReservations($limitNumber, $offsetNumber,$reservationDateTime, $accepted, $booksId, $usersId, $id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
    
    public function getCheckouts(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $arguments = json_decode(file_get_contents("php://input"), true);
        $id = isset($arguments["id"]) ? '%' . $arguments["id"] : "%";
        $usersId = isset($arguments["usersId"]) ? '%' . $arguments["usersId"] : "%";
        $booksId = isset($arguments["booksId"]) ? $arguments["booksId"] : "%";
        $checkoutDateTime = isset($arguments["checkoutDateTime"]) ? '%' .$arguments["checkoutDateTime"] :"%";
        $returnDateTime = isset($arguments["returnDateTime"]) ? '%' .$arguments["returnDateTime"] : "%";
        $maxAllowedDate = isset($arguments["maxAllowedDate"]) ? '%' .$arguments["maxAllowedDate"] : '%';
        $fine = isset($arguments["fine"]) ? '%' .$arguments["fine"] : '%';
        $isPaid = isset($arguments["isPaid"]) ? '%' .$arguments["isPaid"] : '%';
        $limitNumber = isset($arguments["limit"]) ? $arguments["limit"] : 20;
        $offsetNumber = isset($arguments["offset"]) ? $arguments["offset"] : 0;

        $data = $db->getCheckouts($limitNumber, $offsetNumber,$id, $usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate, $fine, $isPaid);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');

    }
    public function getCheckoutUser(Request $request, Response $response, array $args) {
        $payloadData = $_GET['data'];
        $json = json_decode($payloadData);
        $id = $json->id;
        $this->response = $response;
        $db = new DB();
        $data = $db->getCheckoutUser($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    
    public function getReservationUser(Request $request, Response $response, array $args) {
        $payloadData = $_GET['data'];
        $json = json_decode($payloadData);
        $id = $json->id;
        $this->response = $response;
        $db = new DB();
        $data = $db->getReservationUser($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getFavoriteBooks(Request $request, Response $response, array $args) {
        $payloadData = $_GET['data'];
        $json = json_decode($payloadData);
        $id = $json->id;
        $this->response = $response;
        $db = new DB();
        $data = $db->getFavoriteBooks($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function getFavoriteAuthors(Request $request, Response $response, array $args) {
        $payloadData = $_GET['data'];
        $json = json_decode($payloadData);
        $id = $json->id;
        $this->response = $response;
        $db = new DB();
        $data = $db->getFavoriteAuthors($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProfilePageData(Request $request, Response $response, array $args) {
        $payloadData = $_GET['data'];
        $json = json_decode($payloadData);
        $id = $json->id;
        $this->response = $response;
        $db = new DB();
        $data = $db->getProfilePageData($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function saveProfileData(Request $request, Response $response, array $args) {
        $this->response = $response;
        $contents = json_decode(file_get_contents('php://input'), true);
        $firstName = $contents['firstName'];
        $lastName = $contents['lastName'];
        $email = $contents['email'];
        $id = $contents['currentUser'];
        $db = new DB();
        $db->saveProfileData($id,$firstName,$lastName,$email);
        return $response;
    }
    public function getAllUsers(Request $request, Response $response, array $args) {
        $this->response = $response;
        $db = new DB();
        $data = $db->getAllUsers();
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function checkToken(Request $request, Response $response, array $args) {
        $this->response = $response;
        $token = $_REQUEST[0];
        $db = new DB(); 
        $checkAnswer = $db->checkToken($token);
        $payload = json_encode($checkAnswer);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }
    public function updatePassword(Request $request, Response $response, array $args) {
        $this->response = $response;
        $contents = json_decode(file_get_contents('php://input'), true);
        $id = $contents['id'];
        $newPassword = $contents['password']['password'];
        $hashed_pass = password_hash($newPassword, CRYPT_SHA256);
        $db = new DB();
        $db->updatePassword($hashed_pass, $id);
        return $response;
    }
    public function getAdminSpecificBooks(Request $request, Response $response, array $args) {
        $this->response = $response;
        $id = $_GET['id'];

        $db = new DB();
        $data = $db->getAdminSpecificBooks($id);
        $result = json_encode($data);
        $response->getBody()->write($result);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function handleSpecificBook(Request $request, Response $response, array $args) {
        $this->response = $response;
        $db = new DB();
        if($request->getMethod() == 'DELETE') {
            $contents = json_decode(file_get_contents('php://input'), true);
            $id = $contents['userId'];
            $db->deleteSpecificBook($id);
        }
        $contents = json_decode(file_get_contents('php://input'), true);
         
         $stock = $contents['stock'];
         $qrCode = $contents['qrCode'];
         $status = $contents['status'];
         if($request->getMethod() == 'POST') { 
            $bookMetaId = $contents['bookMetaId'];
            $db->newBook($stock, $qrCode, $status, $bookMetaId);
         } else {
        $id = $contents['id'];
         $db->updateSpecificBook($id,$stock,$qrCode,$status);
        }
        return $response;
    }
}

