<?php

namespace Vinci;


class Image
{

    /**
     * @var string
     */
    protected $content;


    /**
     * Result constructor.
     * @param string $content - String containing the image data
     */
    public function __construct($content)
    {

        $this->content = $content;

    }

    /**
     *
     * Create object from string containing the image data
     *
     * @param string $string
     * @return Image
     */
    public static function createFromString($string) {

        return new self( (string) $string );

    }

    /**
     *
     * Create object from image path
     *
     * @param string $path
     * @return Image|false
     */
    public static function createFromPath($path) {

        if (file_exists($path) && is_file($path)) {

            $content = file_get_contents($path);

            if ($content !== false) {
                return self::createFromString($content);
            }

        }

        return false;
    }

    /**
     *
     * Create object from image url
     *
     * @param string $url
     * @return Image
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createFromUrl($url) {

        return self::createFromString( Request::get($url) );

    }

    /**
     *
     * Save image
     *
     * @param string $path - The path to save the file to
     *
     * @return int|bool - Returns the number of bytes that were written to the file, or
     * false on failure
     */
    public function save($path) {

        return file_put_contents($path, $this->content);

    }


    /**
     * Output image to browser or file
     *
     * @return bool - true on success or false on failure.
     */
    public function display() {

        $imageInfo = getimagesizefromstring($this->content);

        if (isset($imageInfo['mime'])) {
            header('Content-Type: ' . $imageInfo['mime']);
            echo $this->content;
            return true;
        }

        return false;
    }

    /**
     *
     * Return string containing the image data
     *
     * @return string
     */
    public function getString() {

        return $this->content;

    }


}