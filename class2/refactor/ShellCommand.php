<?php


class ShellCommand
{
    
    /**
     * @param Configuration $configuration
     * @param $imagePath
     * @param $newPath
     * @return string
     */
    public function defaultShellCommand($configuration, $imagePath, $newPath) {
        $w = $configuration->obtainWidth();
        $h = $configuration->obtainHeight();

        $command = $configuration->obtainConvertPath() ." " . escapeshellarg($imagePath) .
            " -thumbnail ". (!empty($h) ? 'x':'') . $w ."".
            ($configuration->obtainMaxOnly()== true ? "\>" : "") .
            " -quality ". escapeshellarg($configuration->obtainQuality()) ." ". escapeshellarg($newPath);

        return $command;
    }

    public function commandWithScale($imagePath, $newPath, $configuration) {
        $resize = composeResizeOptions($imagePath, $configuration);

        $cmd = $configuration->obtainConvertPath() ." ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
            " -quality ". escapeshellarg($configuration->obtainQuality()) . " " . escapeshellarg($newPath);

        return $cmd;
    }
}