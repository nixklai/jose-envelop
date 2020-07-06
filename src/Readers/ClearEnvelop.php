<?php

namespace Envelopes\Readers;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
use Jose\Object\JWK;
use Jose\Verifier;
use Envelopes\Traits\ConvertArrayToCheckerManagerTrait;
use Jose\Loader;


class ClearEnvelop implements ReaderInterface
{
    use ConvertArrayToCheckerManagerTrait;

    public $token = '';
    public $jws = null;
    public $jwk = null;
    public $allowed_algorithms = ['RS256', 'RS512'];

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
     * Inject the private key
     * @param $key
     * @return $this
     */
    public function loadKey($key)
    {
        if (!$key instanceof JWK)
            $this->jwk = JWKFactory::createFromValues($key);

        return $this;
    }

    /*================================================
     | Reading stuff
     |================================================
     */
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

    /*================================================
     | Logic stuff
     |================================================
     */
    /**
     * Determine whether the token is valid, duh
     * @return bool
     */
    public function isValid()
    {
        try {
            $verifier = Verifier::createVerifier($this->allowed_algorithms);
            return (is_null(
                $verifier->verifyWithKey($this->jws, $this->jwk)
            ));
        } catch (\InvalidArgumentException $e) { // gratefully reject token
            return false;
        }
    }
}