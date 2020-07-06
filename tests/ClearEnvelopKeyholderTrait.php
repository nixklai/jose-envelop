<?php

namespace Envelopes\Tests;

use Jose\Factory\JWKFactory;

trait ClearEnvelopKeyholderTrait
{
    private function getVerifyingKey(){
        return $this->getKey('public_verifying_key');
    }

    private function getSigningKey(){
        return $this->getKey('private_signing_key');
    }

    private function getKey($keyname){
        $filename = __DIR__ . sprintf('/data/%s.json', $keyname);
        $array = json_decode(file_get_contents($filename), true);
        return JWKFactory::createFromValues($array);
    }
}