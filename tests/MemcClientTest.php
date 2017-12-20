<?php

namespace Tests;

use App\Client;
use PHPUnit\Framework\TestCase;

/**
 * @property Client client
 */
class MemcClientTest extends TestCase
{
    protected function setUp()
    {
        $this->client = new Client();
        $this->client->addServer('localhost', 11211);
        $this->client->flushAll();
    }

    /**
     * @test
     */
    public function canSetKeyValuePair()
    {
        $setResult = $this->client->set('foo', 'bar');

        $this->assertEquals('STORED', $setResult);
    }

    /**
     * @test
     */
    public function canNotGetNonExistingValue()
    {
        $getResult = $this->client->get('foo');

        $this->assertEquals('END', $getResult);
    }

    /**
     * @test
     */
    public function canGetExistingValue()
    {
        $this->client->set('foo', 'bar');
        $getResult = $this->client->get('foo');

        $this->assertEquals('bar', $getResult);
    }

    /**
     * @test
     */
    public function canNotDeleteNonExistingValue()
    {
        $delResult = $this->client->delete('foo');
        $this->assertEquals('NOT_FOUND', $delResult);
    }

    /**
     * @test
     */
    public function canDeleteExistingValue()
    {
        $this->client->set('foo', 'bar');
        $delResult = $this->client->delete('foo');
        $this->assertEquals('DELETED', $delResult);
    }
}
