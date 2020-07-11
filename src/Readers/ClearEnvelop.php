<?php

namespace Envelopes\Readers;

use Envelopes\Traits\ReaderKeyLoadingTrait;
use Jose\Loader;
use Jose\Verifier;
use InvalidArgumentException;

class ClearEnvelop implements ReaderInterface
{
    use ReaderKeyLoadingTrait;

    public $jws = null;
    public $allowed_algorithms = ['RS256', 'RS512'];

    /**
     * Intake token and store it
     * @param $token
     * @return $this
     */
    public function load($token)
    {
        $this->jws = (new Loader())->load($token);
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
        } catch (InvalidArgumentException $e) { // gratefully reject token
            return false;
        }
    }
}