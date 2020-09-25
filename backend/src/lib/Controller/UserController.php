<?php

namespace skoolBiep\Controller;

use skoolBiep\DB;
use skoolBiep\Form;
use skoolBiep\Entity\User;
use skoolBiep\Util\CreateJWT;

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
        //todo check if these are filled in
        $data = json_decode(file_get_contents("php://input"), TRUE);

        try{
            $formEmail = $data["email"];
            $formPassword = $data["password"];
        } catch(Exception $e){
            
        }
        
        $userId = $this->validateUser($formEmail, $formPassword);
        if(!$userId){
            echo 'Caught exception: combo not found \n';
            return $response->withStatus(401);
        }
        else {            
            $payload = [];
            $payload['id'] = $userId;
            $jwt = new CreateJWT($userId);
            $token = $jwt();
            
            $response->getBody()->write($token);
            return $response->withHeader('Authorization', 'Bearer: '. $token);
        }
    }

    function validateUser($formEmail, $formPassword)
    {   
        $user = null;
        $db = $this->container->get('db');
        $sql = $db->prepare("select id, password from users where email = :email");
        $sql->bindValue(':email',$formEmail);
        $res =  $sql->execute();
        $data = $res->fetchArray(SQLITE3_ASSOC);
        if ($data) {
            if (password_verify($formPassword, $data['password'])) {
                $user = $data['id'];
            }
        }

       return $user;
    }

}
