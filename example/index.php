<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Vinci\Vinci;
use GuzzleHttp\Exception\GuzzleException;

$path = __DIR__ . '/../img/photo.jpg';

try {

    $vinci = new Vinci();

    // get file id
    $fileId = $vinci->upload(file_get_contents($path));

    // download filters
    $filters = $vinci->filters();

    // then for an example get a random filter id
    $filterId = $filters[array_rand($filters)];

    // download art using file id and filter id
    $image = $vinci->download($fileId, $filterId);

    // display given image
    $image = imagecreatefromstring($image);
    header('Content-type: image/jpeg');
    imagejpeg($image);

} catch (GuzzleException $e) {

    echo $e->getMessage();

}