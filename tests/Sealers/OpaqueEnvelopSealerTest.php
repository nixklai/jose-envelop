<?php

namespace Envelopes\Tests\Sealers;

use Jose\Loader;
use PHPUnit\Framework\TestCase;
use Envelopes\Sealers\OpaqueEnvelop;
use Envelopes\Tests\OpaqueEnvelopKeyholderTrait;

class OpaqueEnvelopSealerTest extends TestCase
{
    use OpaqueEnvelopKeyholderTrait;

    private $test_headers = [
        'kid' => 'Test KID'
    ];
    private $test_payload = [
        'iss' => 'Test Issuer',
        'aud' => 'Test Audience',
        'payload' => ['TestPayload']
    ];
    public $allowed_key_encryption_methods = ['RSA-OAEP'];
    public $allowed_content_encryption_methods = ['A256GCM'];

    public function test_can_add_payload()
    {
        $envelop = new OpaqueEnvelop();

        $envelop->setIssuer($this->test_payload['iss']);
        $envelop->setAudience($this->test_payload['aud']);
        $envelop->setPayload('payload', $this->test_payload['payload']);

        $this->assertEquals($envelop->payload, $this->test_payload);
    }

    public function test_can_seal_enevelop()
    {
        $envelop = new OpaqueEnvelop();

        // Load key
        $envelop->loadKey($this->getEncryptionKey(), $this->test_headers['kid']);

        // Load payload
        $envelop->setIssuer($this->test_payload['iss']);
        $envelop->setAudience($this->test_payload['aud']);
        $envelop->setPayload('payload', $this->test_payload['payload']);

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
            $this->test_payload,
        );
    }
}
