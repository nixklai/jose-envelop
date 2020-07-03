<?php
namespace Envelopes\Traits;
use Jose\Factory\CheckerManagerFactory;

trait ConvertArrayToCheckerManagerTrait
{
    protected function convertToCheckerManager($array){
        return CheckerManagerFactory::createClaimCheckerManager($array);
    }
}