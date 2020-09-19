<?php

namespace Envelopes\Tests\Readers;

use Envelopes\Readers\OpaqueEnvelop;
use Envelopes\Readers\OpaqueEnvelop as OpaqueEnvelopReader;
use PHPUnit\Framework\TestCase;
use Envelopes\Sealers\OpaqueEnvelop as OpaqueEnvelopSealer;
use Envelopes\Tests\CommonPayloadSettingTrait;
use Envelopes\Tests\TestDataTrait;
use Envelopes\Tests\OpaqueEnvelopKeyholderTrait;

class OpaqueEnvelopReaderTest extends TestCase
{
    use OpaqueEnvelopKeyholderTrait;
    use TestDataTrait;
    use CommonPayloadSettingTrait;

    public function test_can_load_key()
    {
        $envelop = new OpaqueEnvelopReader();
        $envelop->loadKey($this->getDecryptionKey(true));
        $this->assertEquals($envelop->jwk, $this->getDecryptionKey());
    }

    public function test_can_decrypt_correct_token()
    {
        $jwe = $this->generate_test_token();
        $envelop = new OpaqueEnvelopReader();
        $envelop
            ->load($jwe)
            ->loadKey($this->getDecryptionKey());

        $this->assertTrue($envelop->isValid());
    }

    public function test_cannot_decrypt_incorrect_token()
    {
        $jwe = str_replace('a', 'b', $this->generate_test_token());
        $envelop = new OpaqueEnvelopReader();
        $envelop
            ->load($jwe)
            ->loadKey($this->getDecryptionKey());

        $this->assertFalse($envelop->isValid());
    }

    protected function generate_test_token()
    {
        return $this
            ->set_common_payload(new OpaqueEnvelopSealer())
            ->loadKey($this->getEncryptionKey(), 'Test KID')
            ->seal();
    }
}
