<?php

class UrlImage
{
    private $path;
    private $valid_http_protocols = array('http', 'https');

    public function __construct($url = '')
    {
        $this->path = $this->sanitize($url);
    }

    private function sanitize($path)
    {
        return urldecode($path);
    }

    public function sanitizedPath()
    {
        return $this->path;
    }

    public function isHttpProtocol()
    {
        return in_array($this->obtainScheme(), $this->valid_http_protocols);
    }

    private function obtainScheme()
    {
        if ($this->path == '') {
            return '';
        }
        $urlParsed = parse_url($this->path);
        return $urlParsed['scheme'];
    }

    public function obtainFileName()
    {
        $finfo = pathinfo($this->path);
        list($filename) = explode('?', $finfo['basename']);
        return $filename;
    }
}