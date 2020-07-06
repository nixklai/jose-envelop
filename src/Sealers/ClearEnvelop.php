<?php


namespace Envelopes\Sealers;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
use Jose\Object\JWK;

class ClearEnvelop implements SealerInterface
{
    public $kid = null;
    public $jwk;
    public $payload = [];

    /**
     * Define the signer key
     * @param $key
     * @return $this
     */
    public function loadKey($key, $kid = null)
    {
        if (!is_null($kid))
            $this->kid = $kid;
        if (!$key instanceof JWK)
            $key = JWKFactory::createFromValues($key);
        $this->jwk = $key;

        return $this;
    }

    public function seal()
    {
        return JWSFactory::createJWSToCompactJSON(
            $this->payload,
            $this->jwk,
            $this->getProtectedHeader()
        );
    }

    /*-----------------------------------------------
     | Subject-Object related items
     |-----------------------------------------------
     */
    public function setIssuer($iss)
    {
        $this->payload['iss'] = $iss;
        return $this;
    }

    public function setSubject($sub)
    {
        $this->payload['sub'] = $sub;
        return $this;
    }

    public function setAudience($aud)
    {
        $this->payload['aud'] = $aud;
        return $this;
    }

    /*------------------------------------------------
     | Time related
     |------------------------------------------------
     */
    public function setIssueTime($iat = null)
    {
        $iat = (is_null($iat)) ? time() : $iat;
        $this->payload['iat'] = $iat;
        return $this;
    }

    public function setNotBefore($nbf = null)
    {
        if ($nbf = null)
            return $this;

        $this->payload['nbf'] = $nbf;
        return $this;
    }

    public function setExpiry($offset)
    {
        $this->payload['exp'] = time() + $offset;
        return $this;
    }

    public function setExpireAt($exp)
    {
        $this->payload['exp'] = $exp;
        return $this;
    }

    /*================================================
     | Other stuff
     |================================================
     */
    public function setJWTID($jti)
    {
        $payload['jti'] = $jti;
        return $this;
    }

    public function setPayload($key, $value)
    {
        $this->payload[$key] = $value;
        return $this;
    }


    protected function getProtectedHeader()
    {
        $output = [
            'alg' => 'RS256',
        ];

        if (!is_null($this->kid)) {
            $output['kid'] = $this->kid;
        }

        return $output;
    }
}