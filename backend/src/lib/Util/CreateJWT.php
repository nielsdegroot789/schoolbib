<?php

namespace skoolBiep\Util;

use skoolBiep\Model\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;

class CreateJWT
{
    /** @var User $user */
    private $userId;

    /** @var Builder $builder */
    private $builder;

    /** @var Token $token */
    private $token;

    /** @var Sha256  */
    private $signer;

    /** @var Key  */
    private $secret;

    /**
     * CreateJWT constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->builder = new Builder();
        $this->signer = new Sha256();
        //todo change this!
        $this->secret = new Key('ABC');
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        return $this->getToken();
    }

    public function createToken()
    {
        $time = time();
        //todo change this!
        $this->token = $this->builder
            ->issuedBy('localhost:8080')
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->canOnlyBeUsedAfter($time) // Configures the time that the token can be used (nbf claim)
            ->expiresAt($time + 86400) // Configures the expiration time of the token (exp claim)
            ->withClaim('userId', $this->userId) // Configures a new claim, called "username"
            ->getToken($this->signer, $this->secret); // Retrieves the generated token
    }

    /**
     * @return string
     */
    public function getToken()
    {
        if (empty($this->token)) {
            $this->createToken();
        }

        return strval($this->token);
    }
}