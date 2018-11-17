<?php

namespace Submtd\HttpRequest;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

class Http
{
    private static $instance;
    protected $httpClient;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
    }

    public static function init(HttpClient $httpClient = null)
    {
        if (!self::$instance) {
            self::$instance = new self($httpClient);
        }
        return self::$instance;
    }

    public function get($url)
    {
        return $this;
    }
}
