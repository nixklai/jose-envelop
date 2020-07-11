<?php


namespace Envelopes\Sealers;

use Envelopes\Traits\SealerKeyLoadingTrait;
use Jose\Factory\JWEFactory;
use Jose\Object\JWK;

class OpaqueEnvelop implements SealerInterface
{
    use SealerKeyLoadingTrait;
    use CommonPayloadSetterTrait;

    public string $kid = '';
    public JWK $jwk;
    public array $payload = [];

    /**
     * @inheritDoc
     */
    public function seal()
    {
        return JWEFactory::createJWeToCompactJSON(
            $this->payload,
            $this->jwk,
            $this->getHeaders()
        );
    }

    protected function getHeaders()
    {
        $output = [
            'alg' => 'RSA-OAEP',        # Pick one from https://www.rfc-editor.org/rfc/rfc7518.html#section-4.1
            'enc' => 'A256GCM',         # Pick one from https://www.rfc-editor.org/rfc/rfc7518.html#section-5.1
            'zip' => 'GZ'
        ];

        if (!is_null($this->kid))
            $output['kid'] = $this->kid;

        return $output;
    }
}