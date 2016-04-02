<?php

class Configuration
{
    const CACHE_PATH = './cache/';
    const REMOTE_PATH = './cache/remote/';

    const CACHE_KEY = 'cacheFolder';
    const CACHE_MINUTES_KEY = 'cache_http_minutes';
    const CANVASCOLOR_KEY = 'canvas-color';
    const CROP_KEY = 'crop';
    const HEIGHT_KEY = 'height';
    const MAXONLY_KEY = 'maxOnly';
    const OUTPUTFILENAME_KEY = 'output-filename';
    const QUALITY_KEY = 'quality';
    const REMOTE_KEY = 'remoteFolder';
    const SCALE_KEY = 'scale';
    const WIDTH_KEY = 'width';
    
    const CONVERT_PATH = 'convert';

    private $opts;

    public function __construct($opts = array())
    {
        $sanitized = $this->sanitize($opts);

        $defaults = array(
            'crop' => false,
            'scale' => 'false',
            'thumbnail' => false,
            'maxOnly' => false,
            'canvas-color' => 'transparent',
            'output-filename' => false,
            self::CACHE_KEY => self::CACHE_PATH,
            self::REMOTE_KEY => self::REMOTE_PATH,
            'quality' => 90,
            'cache_http_minutes' => 20,
            'width' => null,
            'height' => null
        );

        $this->opts = array_merge($defaults, $sanitized);
    }

    private function sanitize($opts)
    {
        if ($opts == null) {
            return array();
        }

        return $opts;
    }

    public function asHash()
    {
        return $this->opts;
    }

    public function obtainCache()
    {
        return $this->opts[self::CACHE_KEY];
    }

    public function obtainRemote()
    {
        return $this->opts[self::REMOTE_KEY];
    }

    public function obtainConvertPath()
    {
        return self::CONVERT_PATH;
    }

    public function obtainWidth()
    {
        return $this->opts[self::WIDTH_KEY];
    }

    public function obtainHeight()
    {
        return $this->opts[self::HEIGHT_KEY];
    }

    public function obtainCacheMinutes()
    {
        return $this->opts[self::CACHE_MINUTES_KEY];
    }

    public function obtainCrop()
    {
        return $this->opts[self::CROP_KEY];
    }

    public function obtainScale()
    {
        return $this->opts[self::SCALE_KEY];
    }

    public function obtainOutputFilename()
    {
        return $this->opts[self::OUTPUTFILENAME_KEY];
    }

    public function obtainMaxOnly()
    {
        return $this->opts[self::MAXONLY_KEY];
    }

    public function obtainQuality()
    {
        return $this->opts[self::QUALITY_KEY];
    }
    
    public function obtainCanvasColor()
    {
        return $this->opts[self::CANVASCOLOR_KEY];
    }
}