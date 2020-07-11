# `Envelop`

## Why `Envelop`?
It is because I am lazy, and working with JWT (JWS and JWE) is somewhat challenging.

## How?

### How to make a JSON Web Signature token?
Just create a `ClearEnvelop` reader
```php
use Envelopes\Sealers\ClearEnvelop;

$envelop = new ClearEnvelop();
$envelop->setIssuer('Alice')
        ->setAudience('Bob')
        ->setExpiry(60) // Expire in next 60 seconds
        ->setJWTID(time());

echo $envelop->seal(); // Seal up the envelop and done!
```