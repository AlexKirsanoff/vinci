<?php

namespace Vinci;

use GuzzleHttp\Exception\GuzzleException;

class Vinci
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * Vinci constructor.
     */
    public function __construct()
    {

        $this->request = new Request();

    }

    /**
     *
     * Returns a list of filters
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function filters() {

        $response = $this->request->send('list');

        $data = \GuzzleHttp\json_decode($response, true);
        $filters = [];

        foreach ($data as $value) {

            $name = mb_strtolower((string)$value['name']);
            $id = (int)$value['id'];

            $filters[$name] = $id;
        }

        return $filters;
    }

    /**
     *
     * Upload photo and return file id
     *
     * @param $content - String containing the image data
     * @return string - File id
     * @throws GuzzleException
     */
    public function upload($content) {

        $response = $this->request->send('preload', [
            'multipart' => [
                [
                    'name' => 'photo',
                    'filename' => 'photo.jpg',
                    'contents' => $content
                ]
            ]
        ]);

        $fileId = \GuzzleHttp\json_decode($response, true)['preload'];

        return $fileId;

    }

    /**
     *
     * Download art using file id and filter id
     *
     * @param $fileId - File identifier
     * @param $filterId - Filter identifier
     * @return string - String containing the image data
     * @throws GuzzleException
     */
    public function download($fileId, $filterId) {

        return $this->request->send('process/' . $fileId . '/' . $filterId);

    }


}
