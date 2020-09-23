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

        $data = json_decode(file_get_contents("php://input"), TRUE);
        //todo check if these are filled in
        $username = $data["name"];
        $password = $data["password"];
        $userId = validateUser($username, $password);
        

        $params = [];
        $params['id'] = 1;
        $token = $this->createToken($params);
        
        $response->getBody()->write($token);
        return $response->withHeader('Authorization', 'Bearer: '. $token);
    }

    function validateUser($user, $pass)
    {   
        $user = null;
        $db = $this->container->get('db');
        $sql = "select id, password_crypt from users where username = '" . $user . "'";
        $res = $db->query($sql);
        $data = $res->fetchArray(SQLITE3_ASSOC);
        if ($data) {
            if (password_verify($pass, $data['password'])) {
                $this->user->setId($data['id']);
            }
        }
        if($user){
            return $this->user->getId();
        }
        else {
            //throw exception? 
        }
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
