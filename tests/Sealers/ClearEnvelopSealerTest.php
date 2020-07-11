<?php

namespace Envelopes\Tests\Sealers;

use Envelopes\Tests\CommonPayloadSettingTrait;
use Envelopes\Tests\TestDataTrait;
use PHPUnit\Framework\TestCase;
use Jose\Loader;
use Envelopes\Sealers\ClearEnvelop as ClearEnvelopSealer;
use Envelopes\Tests\ClearEnvelopKeyholderTrait;

class ClearEnvelopSealerTest extends TestCase
{
    use ClearEnvelopKeyholderTrait;
    use CommonPayloadSettingTrait;
    use TestDataTrait;

    public function test_can_define_payload(){
        $envelop = $this
            ->generate_test_envelop();
        $envelop->loadKey($this->getSigningKey());

        $this->assertEquals($envelop->payload, $this->test_payload);
    }

    public function test_can_load_key(){
        $envelop = new ClearEnvelopSealer();
        $envelop->loadKey($this->getVerifyingKey(true));
        $this->assertEquals($envelop->jwk, $this->getVerifyingKey());
    }

    public function test_write_kid_to_header()
    {
        $loader = new loader();
        $object_jws = $loader->loadAndVerifySignatureUsingKey(
            $this->generate_test_jws(),
            $this->getVerifyingKey(),
            ['RS256']
        );

        $this->assertEquals(
            $this->test_headers['kid'],
            $object_jws->getSignature(0)->getProtectedHeader('kid')
        );
    }

    public function test_payload_can_be_read()
    {
        $loader = new loader();
        $object_jws = $loader->loadAndVerifySignatureUsingKey(
            $this->generate_test_jws(),
            $this->getVerifyingKey(),
            ['RS256']
        );

        $this->assertEquals(
            $this->test_payload,
            $object_jws->getPayload());
    }

    protected function generate_test_envelop(){
        return $this
            ->set_common_payload(new ClearEnvelopSealer());
    }

    protected function generate_test_jws(){
        return $this
            ->generate_test_envelop()
            ->loadKey($this->getSigningKey(), $this->test_headers['kid'])
            ->seal();
    }
}
