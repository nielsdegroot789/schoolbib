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
        
        $user = $this->validateUser($formEmail, $formPassword);
        if(!$user){
            echo 'Caught exception: combo not found \n';
            return $response->withStatus(401);
        }
        else {            
            $jwt = new CreateJWT($user);
            $token = $jwt();
            
            $response->getBody()->write($token);
            return $response->withHeader('Authorization', 'Bearer: '. $token);
        }
    }

    function validateUser($formEmail, $formPassword)
    {   
        $user = null;

        $db = $this->container->get('db');
        $user = $db->getUserByEmail($formEmail);
        if ($user) {
            if (password_verify($formPassword, $user['password'])) {
                $this->setUser($user);

            }
        }

       return $user;
    }

    public function setUser(Array $user){
        $this->user = $user;
    }
    public function getUser() : Array {
        return $this->user;
    }

}
