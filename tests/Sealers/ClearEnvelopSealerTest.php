<?php

namespace Envelopes\Tests\Sealers;

use PHPUnit\Framework\TestCase;
use Jose\Loader;
use Envelopes\Sealers\ClearEnvelop;
use Envelopes\Tests\ClearEnvelopKeyholderTrait;

class ClearEnvelopSealerTest extends TestCase
{
    use ClearEnvelopKeyholderTrait;

    private $test_kid = 'Test KID';
    private $test_payload = [
        'iss' => 'Test Issuer',
        'aud' => 'Test Audience',
    ];

    protected function generate_jws_with_enevelop(){
        $envelop = new ClearEnvelop();
        $envelop->loadKey($this->getSigningKey(), $this->test_kid);
        $envelop->setIssuer($this->test_payload['iss']);
        $envelop->setAudience($this->test_payload['aud']);
        return $envelop->seal();
    }

    public function test_find_kid()
    {
        $loader = new loader();
        $object_jws = $loader->loadAndVerifySignatureUsingKey(
            $this->generate_jws_with_enevelop(),
            $this->getVerifyingKey(),
            ['RS256']
        );

        $this->assertEquals(
            $this->test_kid,
            $object_jws->getSignature(0)->getProtectedHeader('kid')
        );
    }

    public function test_find_payload()
    {
        $loader = new loader();
        $object_jws = $loader->loadAndVerifySignatureUsingKey(
            $this->generate_jws_with_enevelop(),
            $this->getVerifyingKey(),
            ['RS256']
        );

        $this->assertEquals(
            $this->test_payload,
            $object_jws->getPayload());
    }
}