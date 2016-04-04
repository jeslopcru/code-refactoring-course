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


    public function testIsNotPanoramicImage()
    {
        $shell = new ShellCommand(new Configuration());

        $stub = $this->obtainANotPanoramicImageMock();

        $shell->injectFileSystem($stub);

        $isPanoramic = $shell->isPanoramic($this->pathToRealImage);
        $this->assertFalse($isPanoramic);
    }

    private function obtainANotPanoramicImageMock()
    {
        $stub = $this->getMockBuilder('FileSystem')
            ->getMock();
        $stub->expects($this->exactly(1))
            ->method('getimagesize')->will($this->returnValue([1, 2]));
        return $stub;
    }

    public function testIsAPanoramicImage()
    {
        $shell = new ShellCommand(new Configuration());

        $stub = $this->obtainAPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertTrue($shell->isPanoramic($this->pathToRealImage));
    }

    private function obtainAPanoramicImageMock()
    {
        $stub = $this->getMockBuilder('FileSystem')
            ->getMock();
        $stub->expects($this->exactly(1))
            ->method('getimagesize')->will($this->returnValue([2, 1]));
        return $stub;
    }

    public function testResizeNotPanoramicImageWithWidth()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainANotPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals('x', $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testResizePanoramicImageWithWidth()
    {
        $expectedResult = 66;
        $configuration = new Configuration([Configuration::WIDTH_KEY => $expectedResult,]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainAPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals($expectedResult, $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testResizePanoramicImageWithWidthAndCrop()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 665, Configuration::CROP_KEY => true]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainAPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals('x', $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testResizeNotPanoramicImageWithWidthAndCrop()
    {
        $expectedResult = 45;
        $configuration = new Configuration([
            Configuration::WIDTH_KEY => $expectedResult,
            Configuration::CROP_KEY => true
        ]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainANotPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals($expectedResult, $shell->composeResizeOptions($this->pathToRealImage));
    }


    public function testResizeNotPanoramicImageWithHeight()
    {
        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4,]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainANotPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals('x4', $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testResizeNotPanoramicImageWithHeightAndWidth()
    {
        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4, Configuration::WIDTH_KEY => 5,]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainANotPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals('x4', $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testResizePanoramicImageWithHeightAndWidth()
    {
        $expectedResult = 5;
        $configuration = new Configuration([
            Configuration::HEIGHT_KEY => 4,
            Configuration::WIDTH_KEY => $expectedResult,
        ]);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainAPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals($expectedResult, $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testComposeResizeOptions()
    {
        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4, Configuration::CROP_KEY => true]);
        $shell = new ShellCommand($configuration);
        $this->assertEquals(null, $shell->composeResizeOptions($this->pathToRealImage));
    }

    public function testObtainResizeCommadDefault()
    {
        $configuration = new Configuration();
        $shell = new ShellCommand($configuration);
        $this->assertEquals("convert 'path' -thumbnail  -quality '90' 'newPath'",
            $shell->obtainResizeCommand('path', 'newPath'));
    }

    public function testObtainResizeCommadWithCrop()
    {
        $configuration = new Configuration([Configuration::SCALE_KEY => true,]);
        $shell = new ShellCommand($configuration);
        $this->assertEquals("convert 'path' -thumbnail  -quality '90' 'newPath'",
            $shell->obtainResizeCommand('path', 'newPath'));

        $configuration = new Configuration([Configuration::WIDTH_KEY => 66, Configuration::SCALE_KEY => true,]);
        $shell = new ShellCommand($configuration);
        $this->assertEquals("convert 'path' -thumbnail 66 -quality '90' 'newPath'",
            $shell->obtainResizeCommand('path', 'newPath'));
    }

    public function testObtainResizeCommadWithScale()
    {
        $option = [Configuration::WIDTH_KEY => 66, Configuration::HEIGHT_KEY => 99];
        $configuration = new Configuration($option);
        $shell = new ShellCommand($configuration);

        $stub = $this->obtainANotPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals(
            "convert 'path' -resize 'x99' -size '66x99' xc:'transparent' +swap -gravity center -composite -quality '90' 'newPath'",
            $shell->obtainResizeCommand('path', 'newPath'));

        $stub = $this->obtainAPanoramicImageMock();
        $shell->injectFileSystem($stub);

        $this->assertEquals("convert 'path' -resize '66' -size '66x99' xc:'transparent' +swap -gravity center -composite -quality '90' 'newPath'",
            $shell->obtainResizeCommand('path', 'newPath'));

    }

}
