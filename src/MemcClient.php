<?php

namespace Jougene;

use Jougene\Exceptions\NotFoundException;
use RuntimeException;

class MemcClient
{
    const EOL = "\r\n";

    private $socket;

    public function __construct(string $address, int $port)
    {
        $this->socket = fsockopen($address, $port);
    }

    public function get($key)
    {
        $this->writeSocket("get $key");

        $res = $this->readSocket();
        if($res === 'END') {
            throw new NotFoundException('Getting non existing value');
        }

        if(!is_null($res) && substr($res, 0, 5) === 'VALUE') {
            $resultString = '';
            $res = $this->readSocket();

            while($res !== 'END') {
                $resultString .= $res;
                $res = $this->readSocket();
            }

            return unserialize(base64_decode($resultString));
        } else {
            throw new RuntimeException('FAIL');
        }
    }

    public function set($key, $value)
    {
        $serializedValue = base64_encode(serialize($value));

        $this->writeSocket("set $key 0 3600 " . strlen($serializedValue));
        $this->writeSocket($serializedValue);

        return $this->readSocket() === 'STORED';
    }

    public function delete($key)
    {
        $this->writeSocket("delete $key");

        if($this->readSocket() !== 'DELETED') {
            throw new NotFoundException('Deleting non existing value');
        }

        return true;
    }

    public function flushAll()
    {
        $this->writeSocket("flush_all");
        $this->readSocket();
    }

    private function readSocket()
    {
        return trim(fgets($this->socket));
    }

    private function writeSocket($value)
    {
        fwrite($this->socket, $value . self::EOL);
    }
}