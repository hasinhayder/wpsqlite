<?php


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

use App\Console\Cache;
use App\Console\Log;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
    	$logger = new Log();
    	$logger->info('instantiating cache class');
    	$cache = new Cache();
    	$logger->info('setting a key/value to memcached');
    	$cache->set('test_key', 'test_value');
    }
}