<?php


namespace Envelopes\Sealers;


interface SealerInterface
{
    public function loadKey($key);

    /**
     * Seal up the envelop and return the JWT
     * @return mixed
     */
    public function seal();

    // Must implement all available "Registered Claim Names" as shown in https://tools.ietf.org/html/rfc7519

    /**
     * Define the issuer claim
     * @param $iss
     * @return $this
     */
    public function setIssuer($iss);

    /**
     * Define the audience
     * @param $aud
     * @return $this
     */
    public function setAudience($aud);

    /**
     * Define the subject (who this token is about?)
     * @param $aud
     * @return $this
     */
    public function setSubject($sub);

    /*================================================
     |  Time related
     |================================================
     */

    /**
     * Define a issuing time of the token
     * @param $iat
     * @return $this
     */
    public function setIssueTime($iat);

    /**
     * Define a time for token to activate
     * @param $nbf
     * @return $this
     */
    public function setNotBefore($nbf);

    /**
     * Define a duration for token to expire
     * @param $exp
     * @return $this
     */
    public function setExpireAt($exp);

    /**
     * Define a time for token to expire
     * @param $offset
     * @return $this
     */
    public function setExpiry($offset);

    /**
     * Define a item on the payload JSON tree
     * @param $key
     * @param $value
     * @return $this
     */
    public function setPayload($key, $value);

    /**
     * Define a identifier to this token
     */
    public function setJWTID($jti);

}