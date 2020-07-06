<?php

namespace Envelopes\Tests;

use PHPUnit\Framework\TestCase;
use Envelopes\Readers\ClearEnvelop as ClearEnvelopReader;

class ClearEnvelopReaderTest extends TestCase
{
    use ClearEnvelopKeyholderTrait;

    private $envelop;
    private $no_expiry_jwt = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjEifQ.eyJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE1MTYyMzkwMjJ9.Dyau6xOhGEElbhK4DbF1WMFHV-2VRKSZAiq3bTEblAQ9tfYiGhtCiYxPhJmBvitsFYra4uHB2mPQGgmKgePMPLELHQv6fIbduWV4567Y1dThrmS172PlkM5OpukZKgxchEntH-MRaN6_aohFxSPomS0hcw9H9MU71cvdHhSBUw6KtDqqKk5SHQmPtYFexpVkh_i3MAMOFNgwYKPJDlW-7E7XWV40h3uHA1qpPTmKXYj3VCxA3jNOplwI5K7nt3povRDNhXDZtFAojd_aFWwpIuuEhYjbRdB5GrbGrqy21fdt4pUqKXsSomDIbF47pYcEbL19aDxSGVWxepy4AQ6IAjA2jcOVeqMFlTRxp4mSK3KxAXYGRjDGnwD77E8EMWA10YYrchj6IAuECgh_Spdl0kgrI7RA-yhot-DS3iAS1eErEuX6_GIu1rSMqVTb4us0kMZ6c_Gjb4JFblsXhAQcYDLBmpeId7bvoc7PlCn8YtIgdqMLPobkX5fqOd9tgmMd-cUiEFFtkVb69aDAkZQiozCwDwceIVJthAAvjLT-G5cQ5pFJsIA3Y_5ZNWqBtT0fjnV1cYHEBJOBgrscbMfGsNsa1CPOmqvMhzj_n7wCfmXAVrqPWHs8lpEarVP-5V1n22eby7ZN7J_GvzzHP9K1qTVGRr0YnX8I6-hHWFxiA5A';

    public function testCanGetKIDofJWT()
    {
        $this->envelop = new ClearEnvelopReader();
        $this->envelop->load($this->no_expiry_jwt);

        $this->assertSame(
            $this->envelop->getKID(), "1"
        );
    }

    public function testCanLoadAndReadJWT()
    {
        $this->envelop = new ClearEnvelopReader();
        $this->envelop->load($this->no_expiry_jwt);

        $this->assertSame(
            $this->envelop->getPayload(),
            [
                "name" => "John Doe",
                "iat" => 1516239022,
            ]
        );
    }

    public function test_pass_token_verification()
    {
        $this->envelop = new ClearEnvelopReader();
        $this->envelop->load($this->no_expiry_jwt);
        $this->envelop->loadKey($this->getVerifyingKey());
        $this->assertTrue($this->envelop->isValid());
    }

    public function test_can_fail_token_verification()
    {
        $this->envelop = new ClearEnvelopReader();
        $this->envelop->load(str_replace('a', 'b', $this->no_expiry_jwt));
        $this->envelop->loadKey($this->getVerifyingKey());
        $this->assertFalse($this->envelop->isValid());
    }
}
