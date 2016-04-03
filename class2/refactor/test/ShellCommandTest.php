<?php


class ShellCommandTest extends PHPUnit_Framework_TestCase
{

    private $pathToRealImage = 'images/dog.jpg';

    public function testObtainDefaultShellCommand()
    {
        $expectedSize = 3;
        $configuration = new Configuration(
            [
                Configuration::WIDTH_KEY => $expectedSize,
                Configuration::HEIGHT_KEY => $expectedSize,
            ]
        );
        $shell = new ShellCommand($configuration);
        $this->assertEquals(
            "convert 'imageFilePath' -thumbnail x3 -quality '90' 'newImageFilePath'",
            $shell->defaultShellCommand('imageFilePath', 'newImageFilePath')
        );
    }

    public function testCommandWithScale()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $shell = new ShellCommand($configuration);

        $this->assertEquals(
            "convert 'images/dog.jpg' -resize 'x' -quality '90' 'newpath'",
            $shell->commandWithScale($this->pathToRealImage, 'newpath')
        );
    }

    public function testCommandWithCrop()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $shell = new ShellCommand($configuration);

        $this->assertEquals(
            "convert 'images/dog.jpg' -resize 'x' -size '66x' xc:'transparent' +swap -gravity center -composite -quality '90' 'newpath'",
            $shell->commandWithCrop($this->pathToRealImage, 'newpath', $configuration)
        );
    }


    public function testIsPanoramic()
    {
        $shell = new ShellCommand(new Configuration());
        $this->assertFalse($shell->isPanoramic($this->pathToRealImage));
    }

    public function testComposeResizeOptions()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $shell = new ShellCommand($configuration);

        $this->assertEquals('x', $shell->composeResizeOptions($this->pathToRealImage));

        $configuration = new Configuration([Configuration::WIDTH_KEY => 4, Configuration::CROP_KEY => true]);
        $shell = new ShellCommand($configuration);

        $this->assertEquals('4', $shell->composeResizeOptions($this->pathToRealImage));

        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4,]);
        $shell = new ShellCommand($configuration);

        $this->assertEquals('x4', $shell->composeResizeOptions($this->pathToRealImage));

        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4, Configuration::CROP_KEY => true]);
        $shell = new ShellCommand($configuration);
        $this->assertEquals(null, $shell->composeResizeOptions($this->pathToRealImage));
    }

}
