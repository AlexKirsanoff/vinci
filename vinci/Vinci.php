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
     * @var array
     */
    protected static $filters;


    /**
     *
     * Returns a list of filters
     *
     * @param bool $fully - Return full data when value is set to true
     * @param bool $refresh
     *
     * @return array - Filters
     * @throws GuzzleException
     */
    public static function filters($fully = false, $refresh = false) {

        if (!is_array(self::$filters) || $refresh) {
            self::$filters = self::decode(Request::send('list'));
        }

        if ($fully) {
            return self::$filters;
        }

        $filters = [];
        foreach (self::$filters as $value) {
            $filters[ strtolower($value['name']) ] = (int)$value['id'];
        }

        return $filters;
    }

    /**
     *
     * Upload photo and return file id
     *
     * @param string $image - String containing the image data
     * @return string - File id
     * @throws GuzzleException
     */
    public static function upload($image) {

        return self::decode(
            Request::send('preload', [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'filename' => 'photo.jpg',
                        'contents' => $image
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
     * @return Image
     * @throws GuzzleException
     */
    public static function download($fileId, $filterId) {

        return new Image( Request::send('process/' . $fileId . '/' . $filterId) );

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
