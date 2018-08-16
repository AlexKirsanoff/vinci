<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Vinci\Vinci;
use GuzzleHttp\Exception\GuzzleException;

$path = __DIR__ . '/../img/photo.jpg';

try {

    // get file id
    $fileId = Vinci::upload(file_get_contents($path));

    // download filters
    $filters = Vinci::filters();

    // then for an example get a random filter id
    $filterId = $filters[array_rand($filters)];

    // download art using file id and filter id
    $image = Vinci::download($fileId, $filterId);

    // display given image
    $image = imagecreatefromstring($image);
    header('Content-type: image/jpeg');
    imagejpeg($image);

} catch (GuzzleException $e) {

    echo $e->getMessage();

}