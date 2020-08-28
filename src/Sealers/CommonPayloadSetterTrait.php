<?php


namespace Envelopes\Sealers;


trait CommonPayloadSetterTrait
{
    /*-----------------------------------------------
     | Subject-Object related items
     |-----------------------------------------------
     */

    /**
     * @inheritDoc
     */
    public function setIssuer($iss)
    {
        $this->payload['iss'] = $iss;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSubject($sub)
    {
        $this->payload['sub'] = $sub;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAudience($aud)
    {
        $this->payload['aud'] = $aud;
        return $this;
    }

    /*------------------------------------------------
     | Time related
     |------------------------------------------------
     */
    /**
     * @inheritDoc
     */
    public function setIssueTime($iat = null)
    {
        $iat = (is_null($iat)) ? time() : $iat;
        $this->payload['iat'] = $iat;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setNotBefore($nbf = null)
    {
        if ($nbf == null)
            return $this;

        $this->payload['nbf'] = $nbf;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setExpireIn($offset)
    {
        $this->payload['exp'] = time() + $offset;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setExpiry($exp)
    {
        $this->payload['exp'] = $exp;
        return $this;
    }

    /*================================================
     | Other stuff
     |================================================
     */
    /**
     * @inheritDoc
     */
    public function setJWTID($jti)
    {
        $this->payload['jti'] = $jti;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPayload($key, $value)
    {
        $this->payload[$key] = $value;
        return $this;
    }
}