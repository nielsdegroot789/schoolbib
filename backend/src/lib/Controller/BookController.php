<?php

namespace skoolBiep\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use skoolBiep\DB;

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

        $title = isset($_GET["title"]) ? $_GET["title"] . '%' : "%";
        $author = isset($_GET["authors"]) ? $_GET["authors"] : "%";
        $category = isset($_GET["categories"]) ? $_GET["categories"] : "%";
        $limitNumber = isset($_GET["limit"]) ? $_GET["limit"] : 20;
        $offsetNumber = isset($_GET["offset"]) ? $_GET["offset"] : 0;

        $data = $db->getBookMeta($limitNumber, $offsetNumber, $category, $author, $title);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function getBookMetaFromId(Request $request, Response $response, array $args){
        $this->response = $response;
        $db = new DB();

        $id = $_GET["id"];
        if(!isset($id)){
            throw "Id is not passed correctly";
        }
        
        $data = $db->getBookMetaFromId($id);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
    
    public function getBookMetaCount(Request $request, Response $response, array $args)
    {
        $db = new DB();
        $data = $db->getBookMetaCount();
        $payload = json_encode($data);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getBooks(Request $request, Response $response, array $args)
    {
        $db = new DB();
        $data = $db->getBooks();
        $payload = json_encode($data);

        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function saveBook(Request $request, Response $response, array $args): Response
    {
        //https://stackoverflow.com/questions/49070403/how-to-retrieve-variables-in-php-sent-by-axios-post-request/49070841
        $data = json_decode(file_get_contents("php://input"), true);
        $this->response = $response;

        $db = new DB();
        $title = $data["title"];
        $isbn = $data["isbnCode"];
        $publishDate = $data["publishDate"];
        $rating = $data["rating"];
        $totalPages = $data["totalPages"];
        $sticker = $data["sticker"];
        $language = $data["language"];
        $readingLevel = $data["readingLevel"];
        $authors = $data["authors"];
        $publishers = $data["publishers"];
        $categories = $data["categories"];

        if ($data['id']) {
            $id = $data['id'];
            $data = $db->saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel, $authors, $publishers, $categories, $id);
        } else {
            $data = $db->saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel, $authors, $publishers, $categories);
        }
        $response->getBody()->write($data);
        return $response;
    }

    public function setUserName($user)
    {
        $this->username = $user;
    }

    public function getUserID()
    {
        return $this->id;
    }

    public function getFilterResults(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $searchVal ='%' . $_GET[0] . '%';
        $db = new DB();
        $searchResults = $db->searchFilters($searchVal);
        $json = json_encode($searchResults);
        $response->getBody()->write($json);
        return $response;
    }

}
