<?php


namespace Envelopes\Generators;

use Jose\Object\JWK;
use Jose\Factory\JWKFactory;

class ClearKeyGenerator
{
    public JWK $jwk;

    public function __construct($settings = []){
        $this->jwk = JWKFactory::createKey(array_merge([
            'kty'  => 'EC',
            'crv' => 'P-256',
            'use'  => 'sig',
        ], $settings));
        return $this;
    }

    public function getPrivateKey($need_string = true){
        if($need_string)
            return json_encode($this->jwk);
        return $this->jwk;
    }

    public function getPublicKey($need_string = true){
        if($need_string)
            return json_encode($this->jwk->toPublic());
        return $this->jwk->toPublic();
    }
}