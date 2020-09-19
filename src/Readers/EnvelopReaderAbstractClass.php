<?php


namespace Envelopes\Readers;


use Envelopes\Traits\ReaderKeyLoadingTrait;
use Jose\Loader;

abstract class EnvelopReaderAbstractClass
{
    use ReaderKeyLoadingTrait;

    public $raw_token = '';

    /*================================================
     | Reading stuff
     |================================================
     */
    /**
     * Intake token and store it
     * @param $token
     * @return $this
     */
    public function load($token)
    {
        $this->raw_token = $token;
        $this->token = (new Loader())->load($token);
        return $this;
    }

    /**
     * Return KID
     * @return mixed
     */
    public function getKID()
    {
        return $this->token
            ->getSignature(0)
            ->getProtectedHeader('kid');
    }

    /**
     * Return payload
     * @return mixed
     */
    public function getPayload()
    {
        return $this->token
            ->getPayload();
    }
}
