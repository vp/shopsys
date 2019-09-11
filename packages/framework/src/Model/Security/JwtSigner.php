<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Model\Security;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;

class JwtSigner
{
    /**
     * @var string
     */
    protected $superSecretKeyToSignToken;

    public function __construct()
    {
        // Token should be configurable from parameters, or Public-Private Key method (RSA) should be used
        $this->superSecretKeyToSignToken = 'thisIsNotReallySecure';
    }

    /**
     * @return \Lcobucci\JWT\Signer\Key
     */
    public function getKey(): Key
    {
        return new Key($this->superSecretKeyToSignToken);
    }

    /**
     * @return \Lcobucci\JWT\Signer
     */
    public function getSigner(): Signer
    {
        return new Signer\Hmac\Sha256();
    }
}
