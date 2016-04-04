<?php


class ResizerOptions
{
    private $configuration;
    private $fileSystem;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->fileSystem = new FileSystem();

    }

    public function obtainResizerOption($imagePath, $newPath)
    {
        $cmd = $this->defaultOptions($imagePath, $newPath);

        if ($this->isWidthDefined() && $this->isHeightDefined()) {
            $cmd = $this->withCrop($imagePath, $newPath);

            if ($this->isScaledDefined()) {
                $cmd = $this->withScale($imagePath, $newPath);
            }
        }

        return $cmd;
    }

    public function defaultOptions($imagePath, $newPath)
    {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();

        $command = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) .
            " -thumbnail " . (!empty($h) ? 'x' : '') . $w . "" .
            ($this->configuration->obtainMaxOnly() == true ? "\>" : "") .
            " -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $command;
    }

    /**
     * @return bool
     */
    private function isWidthDefined()
    {
        return !empty($this->configuration->obtainWidth());
    }

    /**
     * @return bool
     */
    private function isHeightDefined()
    {
        return !empty($this->configuration->obtainHeight());
    }

    public function withCrop($imagePath, $newPath)
    {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();
        $resize = $this->dimensionsOption($imagePath);

        $cmd = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) . " -resize " . escapeshellarg($resize) .
            " -size " . escapeshellarg($w . "x" . $h) .
            " xc:" . escapeshellarg($this->configuration->obtainCanvasColor()) .
            " +swap -gravity center -composite -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }

    public function dimensionsOption($imagePath)
    {
        $resize = "x" . $this->configuration->obtainHeight();

        if ($this->needResize($this->hasCrop(), $this->isPanoramic($imagePath))) {
            $resize = $this->configuration->obtainWidth();
        }

        return $resize;
    }

    private function needResize($hasCrop, $isPanoramicImage)
    {
        return
            (!$hasCrop && $isPanoramicImage) ||
            ($hasCrop && !$isPanoramicImage);
    }

    private function hasCrop()
    {
        return (true === $this->configuration->obtainCrop());
    }

    public function isPanoramic($imagePath)
    {
        list($width, $height) = $this->fileSystem->getimagesize($imagePath);
        return $width > $height;
    }

    private function isScaledDefined()
    {
        return true === $this->configuration->obtainScale();
    }

    public function withScale($imagePath, $newPath)
    {
        $resize = $this->dimensionsOption($imagePath, $this->configuration);

        $cmd = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) . " -resize " . escapeshellarg($resize) .
            " -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }

    public function injectFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }
}