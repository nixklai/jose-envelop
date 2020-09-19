<?php


namespace Envelopes\Readers;

use Envelopes\Traits\ReaderKeyLoadingTrait;
use Jose\Loader;
use Jose\Object\JWE;
use InvalidArgumentException;

class OpaqueEnvelop extends EnvelopReaderAbstractClass implements ReaderInterface
{
    use ReaderKeyLoadingTrait;

    public $token;
    public $support_key_encryption = ['RSA-OAEP'];
    public $support_content_encryption = ['A256GCM'];

    public function isValid()
    {
        try {
            (new Loader())->loadAndDecryptUsingKey(
                $this->raw_token,
                $this->jwk,
                $this->support_key_encryption,
                $this->support_content_encryption
            );
            return true;
        } catch (InvalidArgumentException $e){
            return false;
        }

    }
}