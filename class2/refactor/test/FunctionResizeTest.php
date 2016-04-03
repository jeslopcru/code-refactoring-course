<?php

class FunctionResizeTest extends PHPUnit_Framework_TestCase
{

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
    
    public function setUp()
    {
        $this->root = org\bovigo\vfs\vfsStream::setup();
    }
}

?>
