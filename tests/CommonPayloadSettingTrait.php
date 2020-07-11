<?php


namespace Envelopes\Tests;

trait CommonPayloadSettingTrait
{
    protected function set_common_payload($envelop)
    {
        $envelop
            ->setIssuer($this->test_payload['iss'])
            ->setSubject($this->test_payload['sub'])
            ->setAudience($this->test_payload['aud'])
            ->setJWTID($this->test_payload['jti'])
            ->setPayload('payload', $this->test_payload['payload']);
        return $envelop;
    }
}