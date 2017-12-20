<?php

namespace App;

class Client
{
    const
        EOL = "\r\n"
    ;

    private $socket;

    public function get($key)
    {
        // TODO add parsing outpud from protocol response
        fwrite($this->socket, "get $key" . self::EOL);

//        fgets($this->socket);
        return trim(fgets($this->socket));
    }

    public function set($key, $value)
    {
        fwrite($this->socket, "set $key 0 3600 " . strlen($value) . self::EOL);
        fwrite($this->socket, $value . self::EOL);
        return trim(fgets($this->socket));
    }

    public function delete($key)
    {
        fwrite($this->socket, "delete $key" . self::EOL);
        return trim(fgets($this->socket));
    }

    public function flushAll()
    {
        fwrite($this->socket, "flush_all" . self::EOL);
        fgets($this->socket);
    }

    public function addServer(string $address, int $port)
    {
        $this->socket = fsockopen($address, $port);
    }
}