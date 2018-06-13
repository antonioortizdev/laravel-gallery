<?php
/**
 * Created by PhpStorm.
 * User: Portatil
 * Date: 06/06/2018
 * Time: 16:05
 */

namespace Totti619\Gallery\Libraries\Files;


use Totti619\Gallery\Libraries\Exceptions\NotSupportedFormatException;

/**
 * Class Image
 * @package Totti619\Gallery\Libraries\Files
 */
class Image extends File
{
    /**
     * @var string
     */
    protected $format;

    /**
     * Image constructor.
     * @param string $path
     * @param Folder $folder
     */
    public function __construct(string $path, Folder $folder)
    {
        parent::__construct($path);
        $this->folder = $folder;
        $this->format = self::format($path);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function format(string $name)
    {
        $explode = explode('.', $name);
        return $explode[count($explode) - 1];
    }

    /**
     * @param string $format
     * @return bool
     */
    public static function formatSupported(string $format)
    {
        $supportedFormats = config('gallery.supported_formats');
        foreach ($supportedFormats as $supportedFormat) {
            if($supportedFormat === $format)
                return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * @param string $path
     * @throws NotSupportedFormatException
     */
    public function rename(string $path)
    {
        $format = self::format($path);

        if(!self::formatSupported($format))
            throw new NotSupportedFormatException($format);

        $this->setFormat($format);
        parent::rename($path);
    }

    /**
     * @param string|null $index
     * @return Meta\JSONMeta
     */
    public function meta(string $index = null)
    {
        return parent::meta($index); // TODO: Change the autogenerated stub
    }


}