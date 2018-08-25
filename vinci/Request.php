<?php

namespace Vinci;

use GuzzleHttp\{
    Client,
    ClientInterface,
    Exception\GuzzleException
};

/**
 * Class Request
 * @package Vinci
 */
class Request
{

    /**
     * @var Client
     */
    protected static $client;

    /**
     *
     * Send request
     *
     * @param string $uri - Uri string
     * @param array $options - Request options to apply
     * @return string - return body of response
     * @throws GuzzleException
     */
    public static function get(string $uri, array $options = []) {

        self::loadClient();

        $response = self::$client->request('POST', $uri, $options);

        return (string) ($response->getBody());
    }

    /**
     *
     * Set guzzle client for sending requests
     *
     * @param ClientInterface $client
     */
    public static function setClient(ClientInterface $client) {

        self::$client = $client;

    }

    /**
     *
     * Set default guzzle client for sending requests
     *
     */
    public static function setDefaultClient() {

        self::setClient(new Client());

    }

    /**
     * Load guzzle client
     */
    protected static function loadClient() {

        if (!(self::$client instanceof ClientInterface)) {
            self::setDefaultClient();
        }

    }

}