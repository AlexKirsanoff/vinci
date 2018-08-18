<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Vinci\Vinci;
use GuzzleHttp\Exception\GuzzleException;

const IMAGE_PATH = __DIR__ . '/../img/photo.jpg';

try {

    // download filters
    $filters = Vinci::filters();

    // get id of filter, for example a poster filter
    $filterId = $filters['poster'];

    // get file id
    $fileId = Vinci::upload(file_get_contents(IMAGE_PATH));

    // download art using file id and filter id
    $image = Vinci::download($fileId, $filterId);

    // display given image
    $image->display();

    // you can also save a image, for this use:
    // $image->save($path);

} catch (GuzzleException $e) {

    echo $e->getMessage();

}