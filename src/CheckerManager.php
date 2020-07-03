<?php
use Jose\Factory\CheckerManagerFactory;
return [
    CheckerManagerFactory::createClaimCheckerManager([
        'exp',
        'iat',
        'nbf'
    ])
];