<?php


namespace Envelopes\Readers;

use Envelopes\Traits\ReaderKeyLoadingTrait;
use Jose\Loader;
use Jose\Verifier;
use InvalidArgumentException;

class OpaqueEnvelop implements ReaderInterface
{
    use ReaderKeyLoadingTrait;

    public $jwe = null;
    public $jwk = null;
    public $allowed_algorithms = ['RS256', 'RS512'];

    public function load($token)
    {
        $this->jwe = (new Loader())->load($token);

        return $this;
    }

    public function getKID()
    {
        return $this->jwe
            ->getSignature(0)
            ->getProtectedHeader('kid');
    }

    public function getPayload()
    {
        return $this->jwe
            ->getPayload();
    }

    public function isValid()
    {
        try {
            $verifier = Verifier::createVerifier($this->allowed_algorithms);
            return is_null($verifier->verifyWithKey($this->jws, $this->jwk));
        } catch (InvalidArgumentException $e) { // gratefully reject token
            return false;
        }
    }
}