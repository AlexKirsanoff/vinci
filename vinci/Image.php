<?php

namespace Vinci;


class Image
{

    /**
     * @var string
     */
    protected $image;

    /**
     * @var resource|null
     */
    protected $resource;

    /**
     * Result constructor.
     * @param string $image - String containing the image data
     */
    public function __construct($image)
    {

        $this->image = $image;

    }

    /**
     *
     * Save image
     *
     * @param string $path - The path to save the file to
     * @param int $quality - quality is optional, and ranges from 0 (worst
     * quality, smaller file) to 100 (best quality, biggest file)
     */
    public function save($path, $quality = 100) {

        imagejpeg($this->getResource(), $path, $quality);

    }


    /**
     * Output image to browser or file
     */
    public function display() {

        header('Content-type: image/jpeg');
        imagejpeg($this->getResource());

    }

    /**
     *
     * Return string containing the image data
     *
     * @return string
     */
    public function getImage() {

        return $this->image;

    }

    /**
     *
     * Return image resource
     *
     * @return resource
     */
    public function getResource() {

        if (!is_resource($this->resource)) {
            $this->resource = imagecreatefromstring($this->image);
        }

        return $this->resource;
    }

}