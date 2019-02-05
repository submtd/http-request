<?php

namespace Submtd\HttpRequest;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Client\Common\HttpMethodsClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\HttpClientDiscovery;

class HttpRequest
{
    /**
     * HttpClient
     */
    protected $client;

    /**
     * method
     */
    protected $method = 'GET';

    /**
     * url
     */
    protected $url;

    /**
     * headers array
     */
    protected $headers = [];

    /**
     * body
     */
    protected $body = [];

    /**
     * status code
     */
    protected $statusCode;

    /**
     * request response
     */
    protected $response;

    /**
     * class constructor
     * @param Http\Client\HttpClient $client
     * @param Http\Message\MessageFactory $messageFactory
     */
    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = new HttpMethodsClient(
            $client ?? HttpClientDiscovery::find(),
            $messageFactory ?? MessageFactoryDiscovery::find()
        );
    }

    /**
     * static constructor
     * @return DBD\HttpRequest\HttpRequest
     */
    public static function init(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        return new static($client, $messageFactory);
    }

    /**
     * get request method
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * set request method
     * @param string $method
     * @return DBD\HttpRequest\HttpRequest
     */
    public function method(string $method = 'GET')
    {
        $this->method = $method;
        return $this;
    }

    /**
     * get request url
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * set request url
     * @param string $url
     * @return DBD\HttpRequest\HttpRequest
     */
    public function url(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * get request headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * set request headers
     * @param array $headers
     * @return DBD\HttpRequest\HttpRequest
     */
    public function headers(array $headers = [])
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * add request header
     * @param string $header
     * @param string $value
     * @return DBD\HttpRequest\HttpRequest
     */
    public function header(string $header, string $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * get request body
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * set request body
     * @param mixed $body
     * @return DBD\HttpRequest\HttpRequest
     */
    public function body(array $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * make the request
     * @return DBD\HttpRequest\HttpRequest
     */
    public function request()
    {
        $response = $this->client->send($this->getMethod(), $this->getUrl(), $this->getHeaders(), http_build_query($this->getBody()));
        $statusCode = $response->getStatusCode();
        $this->statusCode = $statusCode;
        $this->response = $response->getBody()->getContents();
        if ($statusCode < 200 || $statusCode > 299) {
            throw new \Exception($response->getReasonPhrase(), $statusCode);
        }
        return $this;
    }

    /**
     * get the status code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * get the response
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
}
