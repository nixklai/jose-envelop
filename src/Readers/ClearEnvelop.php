<?php

namespace Envelopes\Readers;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
use Jose\Verifier;
use Envelopes\Traits\ConvertArrayToCheckerManagerTrait;
use Jose\Loader;


class ClearEnvelop
{
    use ConvertArrayToCheckerManagerTrait;

    public $token = '';
    public $jws = null;
    public $jwk = null;
    public $allowed_algorithms = ['RS256', 'RS512'];

    public function __construct()
    {
        return $this;
    }

    /**
     * Intake token and store it
     * @param $token
     * @return $this
     */
    public function load($token)
    {
        $this->token = $token;

        $loader = new Loader();
        $this->jws = $loader->load($this->token);

        return $this;
    }


    /**
     * Return KID
     */
    public function getKID()
    {
        return $this->jws
            ->getSignature(0)
            ->getProtectedHeader('kid');
    }

    /**
     * Return payload
     * @return mixed
     */
    public function getPayload()
    {
        return $this->jws
            ->getPayload();
    }

    /**
     * Inject the private key
     * @param $private_jwk
     * @return $this
     */
    public function loadKey($private_jwk){
        if(!$private_jwk instanceof JWKFactory)
            $this->jwk = JWKFactory::createFromValues($private_jwk);

        return $this;
    }


    /**
     * @return bool
     */
    public function isValid(){
        $verifier = Verifier::createVerifier($this->allowed_algorithms);
        return (is_null(
            $verifier->verifyWithKey($this->jws, $this->jwk)
        ));
    }
}