<?php

require_once 'autoload.php';

class Resizer
{

    private $path;
    private $configuration;
    private $fileSystem;

    public function __construct($path, $configuration = null)
    {
        if ($configuration == null) {
            $configuration = new Configuration();
        }
        $this->checkPath($path);
        $this->checkConfiguration($configuration);
        $this->path = $path;
        $this->configuration = $configuration;
        $this->fileSystem = new FileSystem();
    }

    private function checkPath($path)
    {
        if (!($path instanceof UrlImage)) {
            throw new InvalidArgumentException();
        }
    }

    private function checkConfiguration($configuration)
    {
        if (!($configuration instanceof Configuration)) {
            throw new InvalidArgumentException();
        }
    }

    public function injectFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function obtainFilePath()
    {
        $imagePath = '';

        if ($this->path->isHttpProtocol()):
            $filename = $this->path->obtainFileName();
            $local_filepath = $this->configuration->obtainRemote() . $filename;
            $inCache = $this->isInCache($local_filepath);

            if (!$inCache):
                $this->download($local_filepath);
            endif;
            $imagePath = $local_filepath;
        endif;

        if (!$this->fileSystem->file_exists($imagePath)):
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            if (!$this->fileSystem->file_exists($imagePath)):
                throw new RuntimeException();
            endif;
        endif;

        return $imagePath;
    }

    private function isInCache($filePath)
    {
        $fileExists = $this->fileSystem->file_exists($filePath);
        $fileValid = $this->fileNotExpired($filePath);

        return $fileExists && $fileValid;
    }

    private function fileNotExpired($filePath)
    {
        $cacheMinutes = $this->configuration->obtainCacheMinutes();
        return $this->fileSystem->filemtime($filePath) < strtotime('+' . $cacheMinutes . ' minutes');
    }

    private function download($filePath)
    {
        $img = $this->fileSystem->file_get_contents($this->path->sanitizedPath());
        $this->fileSystem->file_put_contents($filePath, $img);
    }

}