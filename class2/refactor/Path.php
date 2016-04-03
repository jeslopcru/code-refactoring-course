<?php


class Path
{
    private $configuration;
    private $fileSystem;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->fileSystem = new FileSystem();

    }

    function composeNewPath($imagePath) {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();
        $filename = $this->fileSystem->md5_file($imagePath);
        $finfo = $this->fileSystem->pathinfo($imagePath);
        $ext = $finfo['extension'];

        $cropSignal = $this->configuration->obtainCrop() == true ? "_cp" : "";
        $scaleSignal = $this->configuration->obtainScale() == true ? "_sc" : "";
        $widthSignal = !empty($w) ? '_w'.$w : '';
        $heightSignal = !empty($h) ? '_h'.$h : '';
        $extension = '.'.$ext;

        $newPath = $this->configuration->obtainCache() .$filename.$widthSignal.$heightSignal.$cropSignal.$scaleSignal.$extension;

        if($this->configuration->obtainOutputFilename()) {
            $newPath = $this->configuration->obtainOutputFilename();
        }

        return $newPath;
    }


}