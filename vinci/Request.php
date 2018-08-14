<?php

namespace Vinci;

use GuzzleHttp\{
    Client, Exception\GuzzleException
};

/**
 * Class Request
 * @package Vinci
 */
class Request
{

    const API_URL = 'http://vinci.camera';

    /**
     * @var Client
     */
    protected $client;

    /**
     *
     * Config for guzzle client
     *
     * @var array
     */
    protected static $config = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {

        $this->client = new Client(array_merge([
            'base_uri' => self::API_URL
        ], self::$config));

    }

    /**
     *
     * Send request
     *
     * @param string $uri - Uri string
     * @param array $options - Request options to apply
     * @return string - return body of response
     * @throws GuzzleException
     */
    public function send(string $uri, array $options = []) {

        $response = $this->client->request('POST', $uri, $options);

        $body = (string)$response->getBody();

        return $body;
    }

    /**
     *
     * Set custom config for guzzle client
     *
     * @param array $config
     */
    public static function setConfig(array $config) {

        self::$config = $config;

    }

}