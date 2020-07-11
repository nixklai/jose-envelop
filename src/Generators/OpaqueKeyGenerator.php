<?php


namespace Envelopes\Generators;

use Jose\Object\JWK;
use Jose\Factory\JWKFactory;

class OpaqueKeyGenerator
{
    public JWK $jwk;

    public function __construct($settings = []){
        return JWKFactory::createKey(array_merge([
            'kty'  => 'RSA',
            'size' => 4096,
            'kid'  => 'KEY1',
            'alg'  => 'RSA-OAEP',
            'use'  => 'enc',
        ], $settings));
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