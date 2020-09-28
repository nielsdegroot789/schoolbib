<?php

namespace skoolBiep\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use skoolBiep\Entity\User;
use skoolBiep\Util\CreateJWT;

class UserController
{
    private $user;
    protected $container;
    protected $response;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $formEmail = $data["email"];
            if (!$formEmail) {
                throw new Exception('Email not filled in correctly');
            }

            $formPassword = $data["password"];
            if (!$formPassword) {
                throw new Exception('Password not filled in correctly');
            }

        } catch (Exception $e) {
            $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
            return $response->withStatus(401);
        }

        try {
            $user = $this->validateUser($formEmail, $formPassword);
            $jwt = new CreateJWT($user);
            $token = $jwt();

            $response->getBody()->write($token);
            return $response->withHeader('Authorization', 'Bearer: ' . $token);
        } catch (Exception $e) {
            $response->getBody()->write('Caught exception: ' . $e->getMessage() . "\n");
            return $response->withStatus(401);
        }
    }

    public function validateUser(String $formEmail, String $formPassword): array
    {
        $user = null;

        $db = $this->container->get('db');
        $user = $db->getUserByEmail($formEmail);
        if ($user) {
            if (password_verify($formPassword, $user['password'])) {
                $this->setUser($user);
                return $user;
            }
        }

        throw new Exception("Combination not found");
    }

    public function setUser(array $user)
    {
        $this->user = $user;
    }
    public function getUser(): array
    {
        return $this->user;
    }

}
