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

    const API_URL = 'http://vinci.camera';

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
    public static function send(string $uri, array $options = []) {

        self::loadClient();

        return (string) (
            self::$client->request(
                'POST',
                self::API_URL . '/' . $uri,
                $options
            )->getBody()
        );

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
     * Load guzzle client
     */
    protected static function loadClient() {

        if (!(self::$client instanceof ClientInterface)) {
            self::setClient(new Client());
        }

    }

}