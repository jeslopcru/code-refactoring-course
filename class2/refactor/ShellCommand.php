<?php


class ShellCommand
{
    private $configuration;
    private $fileSystem;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->fileSystem = new FileSystem();

    }

    public function defaultShellCommand($imagePath, $newPath)
    {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();

        $command = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) .
            " -thumbnail " . (!empty($h) ? 'x' : '') . $w . "" .
            ($this->configuration->obtainMaxOnly() == true ? "\>" : "") .
            " -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $command;
    }

    public function commandWithScale($imagePath, $newPath)
    {
        $resize = $this->composeResizeOptions($imagePath, $this->configuration);

        $cmd = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) . " -resize " . escapeshellarg($resize) .
            " -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }

    public function composeResizeOptions($imagePath)
    {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();

        $resize = "x" . $h;

        if ($this->needResize($this->hasCrop(), $this->isPanoramic($imagePath))) {
            $resize = $w;
        }

        return $resize;
    }

    private function hasCrop()
    {
        return (true === $this->configuration->obtainCrop());
    }

    private function needResize($hasCrop, $isPanoramicImage)
    {
        return
            (!$hasCrop && $isPanoramicImage) ||
            ($hasCrop && !$isPanoramicImage);
    }

    public function isPanoramic($imagePath)
    {
        list($width, $height) = $this->fileSystem->getimagesize($imagePath);
        return $width > $height;
    }

    public function commandWithCrop($imagePath, $newPath)
    {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();
        $resize = $this->composeResizeOptions($imagePath);

        $cmd = $this->configuration->obtainConvertPath() . " " . escapeshellarg($imagePath) . " -resize " . escapeshellarg($resize) .
            " -size " . escapeshellarg($w . "x" . $h) .
            " xc:" . escapeshellarg($this->configuration->obtainCanvasColor()) .
            " +swap -gravity center -composite -quality " . escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }

    public function injectFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }
}