<?php

namespace eindwerk\Util;

use eindwerk\Model\User;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class ValidateJWT
{
    /** @var Token */
    private $token;

    /** @var Sha256  */
    private $signer;

    /** @var Key  */
    private $secret;

    /**
     * ValidateJWT constructor.
     * @param string $jwtString
     */
    public function __construct($jwtString)
    {
        $this->token = (new Parser())->parse($jwtString);
        $this->signer = new Sha256();
        $this->secret = new Key(getenv('JWT_SECRET'));
    }

    public function __invoke()
    {
        return $this->getUser();
    }

    /**
     * @return ValidationData
     */
    private function validationData()
    {
        $data = new ValidationData();
        $data->setIssuer(getenv('DOMAIN'));

        return $data;
    }

    public function validateToken()
    {
        return $this->token->validate($this->validationData()) && $this->token->verify($this->signer, $this->secret);
    }

    /**
     * @return User|false
     */
    public function getUser()
    {
        if (!$this->validateToken()) {
            return false;
        }

        $username = $this->token->getClaim('username');
        return User::fetchByUserName($username);
    }
}