<?php

namespace Envelopes\Tests;

trait OpaqueEnvelopKeyholderTrait
{
    use AccessTestingKeyTrait;

    private function getEncryptionKey(){
        return $this->getKey('public_encryption_key');
    }

    private function getDecryptionKey(){
        return $this->getKey('private_decryption_key');
    }
}