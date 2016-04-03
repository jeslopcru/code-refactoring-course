<?php


class ShellCommand
{
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }
    
    public function defaultShellCommand($imagePath, $newPath) {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();

        $command = $this->configuration->obtainConvertPath() ." " . escapeshellarg($imagePath) .
            " -thumbnail ". (!empty($h) ? 'x':'') . $w ."".
            ($this->configuration->obtainMaxOnly()== true ? "\>" : "") .
            " -quality ". escapeshellarg($this->configuration->obtainQuality()) ." ". escapeshellarg($newPath);

        return $command;
    }

    public function commandWithScale($imagePath, $newPath) {
        $resize = composeResizeOptions($imagePath, $this->configuration);

        $cmd = $this->configuration->obtainConvertPath() ." ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
            " -quality ". escapeshellarg($this->configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }

    public function commandWithCrop($imagePath, $newPath) {
        $w = $this->configuration->obtainWidth();
        $h = $this->configuration->obtainHeight();
        $resize = composeResizeOptions($imagePath, $this->configuration);

        $cmd = $this->configuration->obtainConvertPath() ." ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
            " -size ". escapeshellarg($w ."x". $h) .
            " xc:". escapeshellarg($this->configuration->obtainCanvasColor()) .
            " +swap -gravity center -composite -quality ". escapeshellarg($this->configuration->obtainQuality())." ".escapeshellarg($newPath);

        return $cmd;
    }
}