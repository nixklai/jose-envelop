<?php


namespace Envelopes\Tests;


trait TestDataTrait
{
    private $test_headers = [
        'kid' => 'Test KID'
    ];
    private $test_payload = [
        'iss' => 'Test Issuer',
        'aud' => 'Test Audience',
        'sub' => 'Test Subject',
        'jti' => 'Test JWT ID',
        'payload' => ['TestPayload']
    ];
}