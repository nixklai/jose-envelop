<?php

namespace Envelopes\Tests\Readers;

use PHPUnit\Framework\TestCase;
use Envelopes\Sealers\ClearEnvelop as ClearEnvelopSealer;
use Envelopes\Readers\ClearEnvelop as ClearEnvelopReader;
use Envelopes\Tests\ClearEnvelopKeyholderTrait;
use Envelopes\Tests\AccessTestingKeyTrait;
use Envelopes\Tests\CommonPayloadSettingTrait;
use Envelopes\Tests\TestDataTrait;


class ClearEnvelopReaderTest extends TestCase
{
    use ClearEnvelopKeyholderTrait;
    use TestDataTrait;
    use AccessTestingKeyTrait;
    use CommonPayloadSettingTrait;

    public function test_can_load_key()
    {
        $envelop = new ClearEnvelopReader();
        $envelop->loadKey($this->getVerifyingKey(true));
        $this->assertEquals($envelop->jwk, $this->getVerifyingKey());
    }

    public function test_can_get_KID_of_JWT()
    {
        $envelop = new ClearEnvelopReader();
        $envelop->load($this->generate_test_token());

        $this->assertEquals("Test KID", $envelop->getKID());
    }

    public function test_can_load_and_read_token()
    {
        $envelop = new ClearEnvelopReader();
        $envelop->load($this->generate_test_token());

        $this->assertEqualsCanonicalizing(
            $this->test_payload,
            $envelop->getPayload(),
        );
    }

    public function test_pass_token_verification()
    {
        $token = $this->generate_test_token();
        $envelop = new ClearEnvelopReader();
        $envelop
            ->load($token)
            ->loadKey($this->getVerifyingKey());

        $this->assertTrue($envelop->isValid());
    }

    public function test_can_fail_token_verification()
    {
        $envelop = new ClearEnvelopReader();
        $envelop
            ->load(str_replace('a', 'b', $this->generate_test_token()))
            ->loadKey($this->getVerifyingKey());

        $this->assertFalse($envelop->isValid());
    }

    protected function generate_test_token()
    {
        return $this
            ->set_common_payload(new ClearEnvelopSealer())
            ->loadKey($this->getSigningKey(), 'Test KID')
            ->seal();
    }
}
