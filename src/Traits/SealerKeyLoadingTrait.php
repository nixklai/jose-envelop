<?php


namespace Envelopes\Traits;


use Jose\Factory\JWKFactory;
use Jose\Object\JWK;

trait SealerKeyLoadingTrait
{
    /**
     * @param $key
     * @param null $kid
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
}