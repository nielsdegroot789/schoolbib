<?php

namespace skoolBiep\Controller;

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\BookMeta;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class BookMetaController
{
    private $user;
    protected $container;
    protected $response;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getAllBooks(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        // if ($request->getMethod() == 'GET') {
        //     $form =  $this->loginForm();
        //     $twig = $this->container->get('view');
        //     $res = Form::createForm($this->response, $twig, $form, 'loginform');
        // } else {
        //     // verwerking form
        //     $form =  $this->loginForm();
        //     $this->user = new User();
        //     $this->user->setUserName($request->getParsedBody()['username']);
        //     $id = $this->validateUser($request->getParsedBody()['password']);
        //     echo "User has ID: $id";
        //     echo "tableName : " . $this->user->getTableName();
        // }
        // return $response;

        $data = array(array('title' => 'Rob', 'isbn' => 586383840, 'publishDate' => '20/41/8477', 'rating' => 4, 'totalPages'=>500, 'sticker'=>'idk', 'language'=>'nl', 'readingLevel' => 'easy', 'authors' => 'autheur' , 'publishers' => 'publisher', 'status' => 'ok', 'stock' => 2, 'authorsId' => 1, 'categories' => 'comedy' ),
        array('title' => 'titirtrt', 'isbn' => 8646546, 'publishDate' => '2/1/1495', 'rating' => 2, 'totalPages'=>4100, 'sticker'=>'idk', 'language'=>'en', 'readingLevel' => 'hard', 'authors' => 'autheur2' , 'publishers' => 'publisher2', 'status' => 'ok', 'stock' => 0, 'authorsId' => 5, 'categories' => 'fiction' ));
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
