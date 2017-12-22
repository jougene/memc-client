<?php

namespace Tests;

use Jougene\MemcClient;
use PHPUnit\Framework\TestCase;

/**
 * @property MemcClient client
 */
class MemcClientTest extends TestCase
{
    protected function setUp()
    {
        $this->client = new MemcClient('localhost', 11211);
        $this->client->flushAll();
    }

    /**
     * @expectedException \Jougene\Exceptions\NotFoundException
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
     * @expectedException \Jougene\Exceptions\NotFoundException
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
     * @expectedException \Jougene\Exceptions\NotFoundException
     * @test
     */
    public function canNotGetDeletedKey()
    {
        $this->client->set('foo', 'bar');
        $this->client->delete('foo');
        $this->client->get('foo');
    }
}

class GgWpClass
{
    const FOO = 42;

    private $prop = [];

    private function getProp()
    {
        return $this->prop;
    }
}
