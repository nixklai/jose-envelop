<?php


namespace Envelopes\Sealers;

use Envelopes\Traits\SealerKeyLoadingTrait;
use Jose\Factory\JWSFactory;
use Jose\Object\JWK;

class ClearEnvelop implements SealerInterface
{
    use CommonPayloadSetterTrait;
    use SealerKeyLoadingTrait;

    public string $kid = '';
    public JWK $jwk;
    public array $payload = [];

    /**
     * @inheritDoc
     */
    public function seal()
    {
        return JWSFactory::createJWSToCompactJSON(
            $this->payload,
            $this->jwk,
            $this->getHeaders()
        );
    }

    protected function getHeaders()
    {
        $output = [
            'alg' => 'RS256',
        ];

        if (!is_null($this->kid))
            $output['kid'] = $this->kid;

        return $output;
    }
}