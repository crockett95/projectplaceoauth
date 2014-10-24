<?php

use Crockett95\ProjectPlace\OAuthService;

class OAuthServiceTest extends PHPUnit_Framework_TestCase
{
    public function testAutoloadIsWorking()
    {
        $service = new OAuthService();
        $this->assertTrue(!$service->getStatus());
    }
}
