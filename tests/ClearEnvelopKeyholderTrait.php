<?php

namespace Envelopes\Tests;

trait ClearEnvelopKeyholderTrait
{
    use AccessTestingKeyTrait;

    private function getVerifyingKey(){
        return $this->getKey('public_verifying_key');
    }

    private function getSigningKey(){
        return $this->getKey('private_signing_key');
    }
}