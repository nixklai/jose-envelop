<?php

namespace Envelopes\Readers;

use Envelopes\Traits\ReaderKeyLoadingTrait;
use Jose\Loader;
use Jose\Object\JWS;
use InvalidArgumentException;

class ClearEnvelop extends EnvelopReaderAbstractClass implements ReaderInterface
{
    use ReaderKeyLoadingTrait;

    public string $raw_token;
    public JWS $token;
    public array $allowed_algorithms = ['RS256', 'RS512', 'ES256'];

    /*================================================
     | Logic stuff
     |================================================
     */
    /**
     * Determine whether the token is valid, duh
     * @return bool
     */
    public function isValid()
    {
        try {
            (new Loader())->loadAndVerifySignatureUsingKey(
                $this->raw_token,
                $this->jwk,
                $this->allowed_algorithms
            );
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function getIssuer(){
        return $this->token
            ->getClaim('iss');
    }
}