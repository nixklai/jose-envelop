<?php
include_once "vendor/autoload.php";
use Envelopes\Generators\OpaqueKeyGenerator;

$key = new OpaqueKeyGenerator();
echo ">>>>> Private & Public Key Set <<<<<" . PHP_EOL;

echo $key->getPrivateKey() . PHP_EOL;
echo "=====================================" . PHP_EOL;

echo ">>>>> Public Key <<<<<" . PHP_EOL;
echo $key->getPublicKey() . PHP_EOL;
echo "=====================================" . PHP_EOL;
