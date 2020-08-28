<?php


namespace Envelopes\Readers;


interface ReaderInterface
{
    // Load situational stuff
    public function load($token);

    public function loadKey($key);

    public function getKID();

    public function getPayload();

    public function isValid();
}