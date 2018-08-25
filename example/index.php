<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Vinci\{
    Vinci,
    Image
};
use GuzzleHttp\Exception\GuzzleException;

const IMAGE_PATH = __DIR__ . '/../img/photo.jpg';

try {

    // download filters
    $filters = Vinci::getFilters();

    // get id of filter, for example a first filter id
    $filterId = array_shift($filters);

    // get file id
    $image = Image::createFromPath(IMAGE_PATH);
    $fileId = Vinci::upload($image);

    // download art using file id and filter id
    $image = Vinci::download($fileId, $filterId);

    // display given image
    $image->display();

    // you can also save a image, for this use:
    // $image->save($path);

} catch (GuzzleException $e) {

    echo $e->getMessage();

}