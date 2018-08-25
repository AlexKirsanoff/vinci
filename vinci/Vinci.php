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
     * Returns a list of filters ids
     *
     * @param bool $fully - Return full data when value is set to true
     *
     * @return array - Filters
     * @throws GuzzleException
     */
    public static function getFilters($fully = false) {

        if (!is_array(self::$filters)) {
            self::reloadFilters();
        }

        if ($fully) {

            return self::$filters;

        } else {

            $filters = [];
            foreach (self::$filters as $value) {
                $filters[strtolower($value['name'])] = (int)$value['id'];
            }

            return $filters;

        }

    }

    /**
     *
     * Return filter id by name
     *
     * @param $name - Filter name
     * @return int|null
     * @throws GuzzleException
     */
    public static function searchFilter($name) {

        return self::getFilters()[$name] ?? null;

    }

    /**
     *
     * Reload filters
     *
     * @throws GuzzleException
     */
    public static function reloadFilters() {

        self::$filters = self::decode(self::request('list'));

    }

    /**
     *
     * Upload photo and return file id
     *
     * @param Image $image
     * @return string - File id
     * @throws GuzzleException
     */
    public static function upload(Image $image) {

        return self::decode(
            self::request('preload', [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'filename' => 'photo.jpg',
                        'contents' => $image->getString()
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

        return Image::createFromString( self::request('process/' . $fileId . '/' . $filterId) );

    }

    /**
     *
     * Send request
     *
     * @param $uri - Uri string
     * @param array $options  - Request options to apply
     * @return string - return body of response
     * @throws GuzzleException
     */
    protected static function request($uri, $options = []) {

        return Request::get('http://vinci.camera/' . ltrim($uri, '/') , $options);

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
