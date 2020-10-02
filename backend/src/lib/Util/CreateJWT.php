<?php

namespace skoolBiep\Util;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use skoolBiep\Model\User;

class CreateJWT
{

    // https://git.fullstacksyntra.be/Simondb/Eindwerk-Projectopvolging-Facturatie/src/branch/feature/jwt-auth

    private $user;
    private $builder;
    private $token;
    private $signer;
    private $secret;

    public function __construct($user)
    {
        $this->user = $user;
        $this->builder = new Builder();
        $this->signer = new Sha256();
        $this->secret = new Key(getenv('JWT_SECRET'));
    }

    public function __invoke()
    {
        return $this->getToken();
    }

    public function createToken()
    {
        $time = time();
        $this->token = $this->builder
            ->issuedBy(getenv('JWT_ISSUER'))
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->withClaim('userId', $this->user['id']) // Configures a new claim, called "username"
            ->withClaim('role', $this->user['role']) // Configures a new claim, called "username"
            ->getToken($this->signer, $this->secret); // Retrieves the generated token
    }

    public function getToken()
    {
        if (empty($this->token)) {
            $this->createToken();
        }

        return strval($this->token);
    }
}
