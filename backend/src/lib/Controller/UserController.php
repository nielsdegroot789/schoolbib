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
        if($data['id']){
            $id = $data['id'];
            $data = $db->saveReservationsUser($usersId, $booksId, $reservationDateTime);
        }
        else {
            $data = $db->saveReservationsUser($usersId, $booksId, $reservationDateTime);
        }
        $response->getBody()->write($data);
        return $response;
      
    }
    public function ChangeAccepted($booksId, $userId){
        $db = new DB();
        $sql=$db->exec('UPDATE reservations Set accepted = 1 WHERE booksId = '. $booksId .' AND userId = '. $userId .'');
        if ($db->exec($sql)) {
            return $db->lastInsertRowID();
        } else {
            return false;
        } 
    }

    public function saveCheckoutAdmin(Request $request, Response $response, array $args)
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
            $data = $db->saveCheckoutAdmin($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate);
        }
        else {
            $data = $db->saveCheckoutAdmin($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate);
        }
        $response->getBody()->write($data);
        return $response;
    }

    public function getReservation(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $data = $db->getReservation();
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function getCheckout(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $data = $db->getCheckout();
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

