<?php

namespace Tests;

use App\Client;
use PHPUnit\Framework\TestCase;
use Serializable;

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
        $this->assertTrue($this->client->set('foo', 'bar'));
    }

    /**
     * @expectedException \App\Exceptions\NotFoundException
     * @test
     */
    public function canNotGetNonExistingValue()
    {
        $this->client->get('foo');
    }

    public function someValuesDataProvider()
    {
        $longStr = <<<TEXT
Inhabiting discretion the her dispatched decisively boisterous joy. 
Inhabiting discretion the her dispatched decisively boisterous joy. Inhabit
ing discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. Inhabiting discretion the her dispatched decisively boisterous joy. 
TEXT;

        return [
            'simple string' => ['fooooo'],
            'long string' => [$longStr],
            'object' => [new GgWpClass()]
        ];
    }

    /**
     * @dataProvider someValuesDataProvider
     * @param mixed $value
     * @test
     */
    public function canGetExistingValue($value)
    {
        $this->client->set('foo', $value);
        $getResult = $this->client->get('foo');

        $this->assertEquals($value, $getResult);
    }

    /**
     * @expectedException \App\Exceptions\NotFoundException
     * @test
     */
    public function canNotDeleteNonExistingValue()
    {
        $this->client->delete('foo');
    }

    /**
     * @test
     */
    public function canDeleteExistingValue()
    {
        $this->client->set('foo', 'bar');
        $this->assertTrue($this->client->delete('foo'));
    }

    /**
     * @expectedException \App\Exceptions\NotFoundException
     * @test
     */
    public function canNotGetDeletedKey()
    {
        $this->client->set('foo', 'bar');
        $this->client->delete('foo');
        $this->client->get('foo');
    }
}

class GgWpClass implements Serializable
{
    const FOO = 42;

    private $prop = [];

    private function getProp()
    {
        return $this->prop;
    }

    public function serialize()
    {
        return serialize($this->prop);
    }

    public function unserialize($serialized)
    {
        $this->prop = unserialize($serialized);
    }
}
