<?php

namespace Submtd\HttpRequest;

use Http\Client\HttpClient;
use Http\Message\UriFactory;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

class Http
{
    private static $instance;

    protected $httpClient;
    protected $messageFactory;
    protected $uriFactory;

    protected $headers = [];

    public function __construct(
        HttpClient $httpClient = null,
        MessageFactory $messageFactory = null,
        UriFactory $uriFactory = null
    ) {
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?? MessageFactoryDiscovery::find();
        $this->uriFactory = $uriFactory ?? UriFactoryDiscovery::find();
    }

    public static function init(
        HttpClient $httpClient = null,
        MessageFactory $messageFactory = null,
        UriFactory $uriFactory = null
    ) {
        if (!self::$instance) {
            self::$instance = new self(
                $httpClient,
                $messageFactory,
                $uriFactory
            );
        }
        return self::$instance;
    }

    public function header()
    {
        $arguments = func_get_args();
        return $arguments;
    }

    public function get($url)
    {
        return $this;
    }
}
