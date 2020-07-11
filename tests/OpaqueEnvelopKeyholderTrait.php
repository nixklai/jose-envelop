<?php

namespace Envelopes\Tests;

trait OpaqueEnvelopKeyholderTrait
{
    use AccessTestingKeyTrait;

    private function getEncryptionKey($want_array = false){
        return $this->getKey('public_encryption_key', $want_array);
    }

    private function getDecryptionKey($want_array = false){
        return $this->getKey('private_decryption_key', $want_array);
    }
}