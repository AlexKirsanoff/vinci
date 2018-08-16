<?php

namespace Vinci;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Vinci
 * @package Vinci
 */
class Vinci
{

    /**
     *
     * Returns a list of filters
     *
     * @param bool $fully - Return full data when value is set to true
     * @return array - Filters
     * @throws GuzzleException
     */
    public static function filters($fully = false) {

        $response = self::decode(Request::send('list'));

        if ($fully) { return $response; }

        $filters = [];
        foreach ($response as $value) {
            $filters[ strtolower($value['name']) ] = (int)$value['id'];
        }

        return $filters;
    }

    /**
     *
     * Upload photo and return file id
     *
     * @param string $content - String containing the image data
     * @return string - File id
     * @throws GuzzleException
     */
    public static function upload($content) {

        return self::decode(
            Request::send('preload', [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'filename' => 'photo.jpg',
                        'contents' => $content
                    ]
                ]
            ])
        )['preload'];

    }

    /**
     *
     * Download art using file id and filter id
     *
     * @param string $fileId - File identifier
     * @param string|int $filterId - Filter identifier
     * @return string - String containing the image data
     * @throws GuzzleException
     */
    public static function download($fileId, $filterId) {

        return Request::send('process/' . $fileId . '/' . $filterId);

    }

    /**
     *
     * Json_decode that throws when an error occurs
     *
     * @param string $data
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected static function decode($data) {

        return \GuzzleHttp\json_decode($data, true);

    }


}
