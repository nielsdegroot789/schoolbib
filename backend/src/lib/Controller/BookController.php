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
        $arguments = json_decode(file_get_contents("php://input"), TRUE);
        $title = isset($arguments["title"]) ? '%' . $arguments["title"] : "%";
        $author = isset($arguments["author"]) ? '%' . $arguments["author"] : "%";
        $category = isset($arguments["category"]) ? $arguments["category"] : "%";
        $limitNumber = isset($arguments["limit"]) ? $arguments["limit"] : 20;
        $offsetNumber = isset($arguments["offset"]) ? $arguments["offset"] : 0;

        
        $data = $db->getBookMeta($limitNumber,$offsetNumber, $category,$author,$title);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
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

    public function saveBook(Request $request, Response $response, array $args)
    {
        //https://stackoverflow.com/questions/49070403/how-to-retrieve-variables-in-php-sent-by-axios-post-request/49070841
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $this->response = $response;

        $db = new DB();
        $title = $data["title"];
        $isbn = $data["isbnCode"];
        // $publishDate = $data["publishDate"];
        $rating = $data["rating"];
        $totalPages = $data["totalPages"];
        $sticker = $data["sticker"];
        $language = $data["language"];
        $readingLevel = $data["readingLevel"];
        if($data['id']){
            $id = $data['id'];
            $data = $db->saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel, $id );
        }
        else {
            $data = $db->saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel );
        }
        // $authors = $_POST["authors"];
        // $publishers = $_POST["publishers"];
        // $categories = $_POST["categories"];
        $response->getBody()->write($data);
        return $response;
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


