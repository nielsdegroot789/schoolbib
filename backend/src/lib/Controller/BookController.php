<?php

namespace skoolBiep\Controller;

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\BookMeta;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


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
        $title = $_POST["title"];
        $isbn = $_POST["isbn"];
        $publishDate = $_POST["publishDate"];
        $rating = $_POST["rating"];
        $totalPages = $_POST["totalPages"];
        $sticker = $_POST["sticker"];
        $language = $_POST["language"];
        $authors = $_POST["authors"];
        $readingLevel = $_POST["readingLevel"];
        $publishers = $_POST["publishers"];
        $categories = $_POST["categories"];
        if($_POST['id']){
            //update
        }
        else {
            //create
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
