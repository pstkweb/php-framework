<?php
namespace Pstweb\Common;

class PathParser
{
    public static function removeFileFromPath($path)
    {
        $path = explode("/", $path);
        array_pop($path);

        return implode("/", $path);
    }

    public static function getFileFromPath($path) {
        $path = explode("/", $path);

        return array_pop($path);
    }

    public static function removeFileExt($file)
    {
        $file = explode(".", $file);
        array_pop($file);

        return implode(".", $file);
    }

    public static function getFileExt($file)
    {
        $file = explode(".", $file);

        return array_pop($file);
    }
}