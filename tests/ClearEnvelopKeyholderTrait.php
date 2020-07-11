<?php

namespace Envelopes\Tests;

trait ClearEnvelopKeyholderTrait
{
    use AccessTestingKeyTrait;

    private function getVerifyingKey($want_array = false){
        return $this->getKey('public_verifying_key', $want_array);
    }

    private function getSigningKey($want_array = false){
        return $this->getKey('private_signing_key', $want_array);
    }
}