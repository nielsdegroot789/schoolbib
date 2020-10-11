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
            $address = $data['address'];
            $body = $this->container->get('twig')->render('twig.twig', ['token' => 'testToken']);
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

    public function saveReservationsUser(Request $request, Response $response, array $args)
    {            
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $usersId = $data["usersId"];
        $booksId = $data["booksId"];
        $reservationDateTime = $data["reservationDateTime"];
        $accepted = $data["accepted"];

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
        if($data['id']){
            $id = $data['id'];
            $data = $db->saveCheckouts($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate, $fine, $isPaid);
        }
        else {
            $data = $db->saveCheckouts($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate, $fine, $isPaid);
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
    public function getProfilePageData(Request $request, Response $response, array $args) {
        $id = $_GET['id'];
        $this->response = $response;
        $db = new DB();
        $data = $db->getProfilePageData($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

