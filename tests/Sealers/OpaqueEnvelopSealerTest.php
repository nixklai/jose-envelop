<?php

namespace Envelopes\Tests\Sealers;

use Envelopes\Tests\CommonPayloadSettingTrait;
use Envelopes\Tests\TestDataTrait;
use Jose\Loader;
use PHPUnit\Framework\TestCase;
use Envelopes\Sealers\OpaqueEnvelop as OpaqueEnvelopSealer;
use Envelopes\Tests\OpaqueEnvelopKeyholderTrait;

class OpaqueEnvelopSealerTest extends TestCase
{
    use OpaqueEnvelopKeyholderTrait;
    use CommonPayloadSettingTrait;
    use TestDataTrait;

    public $allowed_key_encryption_methods = ['RSA-OAEP'];
    public $allowed_content_encryption_methods = ['A256GCM'];

    public function test_can_define_payload()
    {
        $envelop = $this->generate_test_envelop();
        $envelop
            ->loadKey($this->getEncryptionKey());

        $this->assertEquals($envelop->payload, $this->test_payload);
    }

    public function test_can_seal_enevelop()
    {
        $envelop = $this
            ->generate_test_envelop()
            ->loadKey($this->getEncryptionKey(), $this->test_headers['kid']);
        $jwe = $envelop->seal();

        $loader = new Loader();
        // Run test
        $this->assertEquals(
            $loader->loadAndDecryptUsingKey(
                $jwe,
                $this->getDecryptionKey(),
                $this->allowed_key_encryption_methods,
                $this->allowed_content_encryption_methods
            )->getPayload(),
            $this->test_payload
        );
    }

    protected function generate_test_envelop()
    {
        return $this->set_common_payload(new OpaqueEnvelopSealer());
    }

    protected function generate_test_jwe()
    {
        return $this
            ->generate_test_envelop()
            ->loadKey($this->getEncryptionKey(), $this->test_headers['kid'])
            ->seal();
    }
}
