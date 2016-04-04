<?php


class ImagePath
{
    private $configuration;
    private $fileSystem;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->fileSystem = new FileSystem();

    }

    public function isInCache($path, $imagePath)
    {
        $isInCache = false;
        if (file_exists($path) == true) {
            $isInCache = true;
            $origFileTime = date("YmdHis", filemtime($imagePath));
            $newFileTime = date("YmdHis", filemtime($path));
            if ($newFileTime < $origFileTime) {
                $isInCache = false;
            }
        }

        return $isInCache;
    }

    public function composeNewPath($imagePath)
    {

        $newPath =
            $this->configuration->obtainCache()
            . $this->obtainFileName($imagePath)
            . $this->widthSignal()
            . $this->heightSignal()
            . $this->cropSignal()
            . $this->scaleSignal()
            . $this->obtainExtensionFile($imagePath);

        if ($this->isConfiguredOutputFilename()) {
            $newPath = $this->configuration->obtainOutputFilename();
        }

        return $newPath;
    }

    private function obtainFileName($imagePath)
    {
        return $this->fileSystem->md5_file($imagePath);
    }

    private function widthSignal()
    {
        $widthSignal = !empty($this->configuration->obtainWidth()) ? '_w' . $this->configuration->obtainWidth() : '';
        return $widthSignal;
    }

    private function heightSignal()
    {
        $heightSignal = !empty($this->configuration->obtainHeight()) ? '_h' . $this->configuration->obtainHeight() : '';
        return $heightSignal;
    }

    private function cropSignal()
    {
        return $this->configuration->obtainCrop() == true ? "_cp" : "";
    }

    private function scaleSignal()
    {
        return $this->configuration->obtainScale() == true ? "_sc" : "";
    }

    private function obtainExtensionFile($imagePath)
    {
        $finfo = $this->fileSystem->pathinfo($imagePath);
        $ext = $finfo['extension'];
        return '.' . $ext;
    }

    private function isConfiguredOutputFilename()
    {
        return $this->configuration->obtainOutputFilename();
    }


}