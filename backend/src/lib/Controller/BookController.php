<?php

namespace skoolBiep\Controller; 

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\BookMeta;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$Reactie = json_decode(file_get_contents(
    "php://input"
));

$data = array();



class BookController
{
    private $user;
    protected $container;
    protected $response;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getBookMeta(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $data = $db->getBookMeta();
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function getBooks(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $db = new DB();
        $data = $db->getBooks();
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    function saveBook()
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
}


