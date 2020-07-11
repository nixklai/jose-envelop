<?php


namespace Envelopes\Tests;


use Jose\Factory\JWKFactory;

trait AccessTestingKeyTrait
{
    private function getKey($keyname){
        $filename = __DIR__ . sprintf('/data/%s.json', $keyname);
        $array = json_decode(file_get_contents($filename), true);
        return JWKFactory::createFromValues($array);
    }
}