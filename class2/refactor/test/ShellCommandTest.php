<?php


class ShellCommandTest extends PHPUnit_Framework_TestCase
{

    private $pathToRealImage =  'images/dog.jpg';

    public function testObtainDefaultShellCommand()
    {
        $expectedSize = 3;
        $configuration = new Configuration(
            [
                Configuration::WIDTH_KEY => $expectedSize,
                Configuration::HEIGHT_KEY => $expectedSize,
            ]
        );
        $shell = new ShellCommand();
        $this->assertEquals(
            "convert 'imageFilePath' -thumbnail x3 -quality '90' 'newImageFilePath'",
            $shell->defaultShellCommand($configuration, 'imageFilePath', 'newImageFilePath')
        );
    }

    public function testCommandWithScale()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $shell = new ShellCommand();

        $this->assertEquals(
            "convert 'images/dog.jpg' -resize 'x' -quality '90' 'newpath'",
            $shell->commandWithScale($this->pathToRealImage, 'newpath', $configuration)
        );

    }

}
