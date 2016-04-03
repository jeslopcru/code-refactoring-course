<?php


require_once __DIR__ . '/../autoload.php';

class FunctionResizeTest extends PHPUnit_Framework_TestCase
{
    private $root;
    private $pathToRealImage =  'images/dog.jpg';

    public function testsanitize()
    {
        $url = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php%20define%20dictionary';
        $expected = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php define dictionary';

        $this->assertEquals($expected, sanitize($url));
    }

    public function testIsInCache()
    {
        $this->assertFalse(isInCache('', ''));

        $path = $this->root->url();
        $imageFile = org\bovigo\vfs\vfsStream::newFile('image.jpq')->at($this->root);
        $this->assertTrue(isInCache($path, $imageFile->url()));

        $imageFile = org\bovigo\vfs\vfsStream::newFile('image.jpq')->lastModified(strtotime('tomorrow'))->at($this->root);
        $this->assertFalse(isInCache($path, $imageFile->url()));
    }


    public function testNewPath()
    {
        $configuration = new Configuration();
        $imageFile = org\bovigo\vfs\vfsStream::newFile('image.jpq')->at($this->root);

        $this->assertEquals(
            './cache/d41d8cd98f00b204e9800998ecf8427e_sc.jpq',
            composeNewPath($imageFile->url(), $configuration));

        $expectedPath = 'thiIsAExpectedPath';
        $configuration = new Configuration([Configuration::OUTPUTFILENAME_KEY => $expectedPath]);
        $this->assertEquals(
            $expectedPath,
            composeNewPath($imageFile->url(), $configuration)
        );
    }

    public function testObtainDefaultShellCommand()
    {
        $expectedSize = 3;
        $configuration = new Configuration(
            [
                Configuration::WIDTH_KEY => $expectedSize,
                Configuration::HEIGHT_KEY => $expectedSize,
            ]
        );

        $this->assertEquals(
            "convert 'imageFilePath' -thumbnail x3 -quality '90' 'newImageFilePath'",
            defaultShellCommand($configuration, 'imageFilePath', 'newImageFilePath')
        );
    }

    public function testIsPanoramic()
    {
        $this->assertFalse(isPanoramic($this->pathToRealImage));
    }

    public function testComposeResizeOptions()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $this->assertEquals('x', composeResizeOptions($this->pathToRealImage, $configuration));

        $configuration = new Configuration([Configuration::WIDTH_KEY => 4, Configuration::CROP_KEY => true]);
        $this->assertEquals('4', composeResizeOptions($this->pathToRealImage, $configuration));

        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4,]);
        $this->assertEquals('x4', composeResizeOptions($this->pathToRealImage, $configuration));

        $configuration = new Configuration([Configuration::HEIGHT_KEY => 4, Configuration::CROP_KEY => true]);
        $this->assertEquals(null, composeResizeOptions($this->pathToRealImage, $configuration));
    }

    public function testCommandWithScale()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $this->assertEquals(
            "convert 'images/dog.jpg' -resize 'x' -quality '90' 'newpath'",
            commandWithScale($this->pathToRealImage, 'newpath', $configuration)
        );

    }

    public function testCommandWithCrop()
    {
        $configuration = new Configuration([Configuration::WIDTH_KEY => 66,]);
        $this->assertEquals(
            "convert 'images/dog.jpg' -resize 'x' -size '66x' xc:'transparent' +swap -gravity center -composite -quality '90' 'newpath'",
            commandWithCrop($this->pathToRealImage, 'newpath', $configuration)
        );

    }
    
    public function setUp()
    {
        $this->root = org\bovigo\vfs\vfsStream::setup();
    }
}

?>
