<?php


namespace Envelopes\Tests;


use Jose\Factory\JWKFactory;

trait AccessTestingKeyTrait
{
    private function getKey($keyname, $want_array = false){
        $filename = __DIR__ . sprintf('/data/%s.json', $keyname);
        $array = json_decode(file_get_contents($filename), true);
        return ($want_array) ? $array : JWKFactory::createFromValues($array);
    }
}