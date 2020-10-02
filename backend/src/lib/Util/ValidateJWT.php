<?php

namespace skoolBiep\Util;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use skoolBiep\Model\User;

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
        return $this->getUserId();
    }

    /**
     * @return ValidationData
     */
    private function validationData()
    {
        $data = new ValidationData();
        $data->setIssuer(getenv('JWT_ISSUER'));

        return $data;
    }

    public function validateToken()
    {
        return $this->token->validate($this->validationData()) && $this->token->verify($this->signer, $this->secret);
    }

    /**
     * @return User|false
     */
    public function getUserId()
    {
        if (!$this->validateToken()) {
            return false;
        }

        $userId = $this->token->getClaim('userId');
        return $userId;
    }
}
