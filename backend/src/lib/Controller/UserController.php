<?php

namespace skoolBiep\Controller;

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UserController
{
    private $user;
    protected $container;
    protected $response;


    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function login(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        var_dump($app);
        $data = json_decode(file_get_contents("php://input"), TRUE);
        //todo check if these are filled in
      
        $formUsername = $data["email"];
        $formPassword = $data["password"];

        $userId = $this->validateUser($formUsername, $formPassword);
        var_dump($userId);
        if(!$userId){
            echo 'Caught exception: combo not found \n';
        }

        $params = [];
        $params['id'] = 1;
        $token = $this->createToken($params);
        
        $response->getBody()->write($token);
        return $response->withHeader('Authorization', 'Bearer: '. $token);
    }

    function validateUser($formUsername, $formPassword)
    {   
        $user = null;
        $db = $this->container->get('db');
        $sql = "select id, password from users where id = '1'";
        $res = $db->query($sql);
        $data = $res->fetchArray(SQLITE3_ASSOC);
        var_dump($formPassword);
        var_dump($data['password']);
        if ($data) {
            if (password_verify($formPassword, $data['password'] )) {
                $user = $data['id'];
            }
        }
       return $user;
    }

    function createToken($payloadData){
        //https://dev.to/robdwaller/how-to-create-a-json-web-token-using-php-3gml

        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        // Create token payload as a JSON string
        $payload = json_encode($payloadData);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'ABC', true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }

}
