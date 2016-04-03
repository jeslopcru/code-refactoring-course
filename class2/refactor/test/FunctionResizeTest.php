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
    
    public function setUp()
    {
        $this->root = org\bovigo\vfs\vfsStream::setup();
    }
}

?>
