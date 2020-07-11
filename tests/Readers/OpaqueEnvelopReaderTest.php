<?php

namespace Envelopes\Tests\Readers;

use PHPUnit\Framework\TestCase;
use Envelopes\Readers\OpaqueEnvelop;
use Envelopes\Tests\OpaqueEnvelopKeyholderTrait;

class OpaqueEnvelopReaderTest extends TestCase
{
    use OpaqueEnvelopKeyholderTrait;

    public function test_can_load_key(){
        $envelop = new OpaqueEnvelop();
        $envelop->loadKey($this->getDecryptionKey());
        $this->assertEquals($envelop->jwk, $this->getDecryptionKey());
    }

//    public function test_can_get_KID(){
//        $envelop = new OpaqueEnvelop();
//        $envelop->load();
//    }
}
