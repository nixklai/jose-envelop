<?php
include_once "vendor/autoload.php";
use Envelopes\Generators\ClearKeyGenerator;

$key = new ClearKeyGenerator();
echo ">>>>> Private & Public Key Set <<<<<" . PHP_EOL;

echo $key->getPrivateKey() . PHP_EOL;
echo "=====================================" . PHP_EOL;

echo ">>>>> Public Key <<<<<" . PHP_EOL;
echo $key->getPublicKey() . PHP_EOL;
echo "=====================================" . PHP_EOL;
