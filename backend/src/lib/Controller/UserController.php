<?php

namespace skoolBiep\Controller;

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$data = array();
class UserController
{
    private $user;
    protected $container;
    protected $response;

    public function selectAllbutOne()
    {
    }
    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function loginForm()
    {
        $fields = array();
        $fields[] = array(
            'type'  => 'text',
            'name'  => 'username',
            'id' => 'username'
        );
        $fields[] = array(
            'type'  => 'password',
            'name' => 'password',
            'id'  => 'password'
        );
        $fields[] = array(
            'type'  => 'submit',
            'name' => 'login',
            'value'  => 'Login'
        );
        $form = ['method' => 'POST', 'fields' => $fields];

        return $form;
    }

    public function login(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        if ($request->getMethod() == 'GET') {
            $form =  $this->loginForm();
            $twig = $this->container->get('view');
            $res = Form::createForm($this->response, $twig, $form, 'loginform');
        } else {
            // verwerking form
            $form =  $this->loginForm();
            $this->user = new User();
            $this->user->setUserName($request->getParsedBody()['username']);
            $id = $this->validateUser($request->getParsedBody()['password']);
            echo "User has ID: $id";
            echo "tableName : " . $this->user->getTableName();
        }
        return $response;
    }

    public function create(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        if ($request->getMethod() == 'GET') {
            $form =  $this->loginForm();
            $twig = $this->container->get('view');
            $res = Form::createForm($this->response, $twig, $form, 'loginform');
        } else {
            // verwerking form
            $form =  $this->loginForm();
            $this->user = new User();
            $this->user->setUserName($request->getParsedBody()['username']);
            $this->saveUser($request->getParsedBody()['password']);
        }
        return $response;
    }

    function validateUser($pass)
    {
        $db = $this->container->get('db');
        $sql = "select id, password_crypt from users where username = '" . $this->user->getUserName() . "'";
        $res = $db->query($sql);
        $data = $res->fetchArray(SQLITE3_ASSOC);
        if ($data) {
            if (password_verify($pass, $data['password_crypt'])) {
                $this->user->setId($data['id']);
            }
        }
        return $this->user->getId();
    }

    function saveUser($pass)
    {
        $db = new DB();
        $hashed_pass = password_hash($pass, CRYPT_SHA256);
        $sql = "INSERT INTO USERS (surname, lastname, email, password) values ('$this->username','test','test' ,'$hashed_pass')";
        if ($db->exec($sql)) {
            return $db->lastInsertRowID();
        } else {
            return false;
        }
    }
    function setUserName($user)
    {
        $this->username = $user;
    }

    function getUserID()
    {
        return $this->id;
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
}

