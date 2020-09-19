<?php


namespace Envelopes\Traits;


use Jose\Factory\JWKFactory;
use Jose\Object\JWK;

trait ReaderKeyLoadingTrait
{
    /**
     * Inject the private key
     * @param $key
     * @return $this
     */
    public function loadKey($key)
    {
        if(!$key instanceof JWK)
            $key = JWKFactory::createFromValues($key);
        $this->jwk = $key;

        return $this;
    }
}