<?php

class ImagePathTest extends PHPUnit_Framework_TestCase
{

    public function testIsSanitizedAtInstantiation()
    {
        $url = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php%20define%20dictionary';
        $expected = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php define dictionary';

        $imagePath = new UrlImage($url);

        $this->assertEquals($expected, $imagePath->sanitizedPath());
    }

    public function testIsHttpProtocol()
    {
        $url = 'https://example.com';

        $imagePath = new UrlImage($url);

        $this->assertTrue($imagePath->isHttpProtocol());

        $imagePath = new UrlImage('ftp://example.com');

        $this->assertFalse($imagePath->isHttpProtocol());

        $imagePath = new UrlImage(null);

        $this->assertFalse($imagePath->isHttpProtocol());
    }

    public function testObtainFileName()
    {
        $url = 'http://martinfowler.com/mf.jpg?query=hello&s=fowler';

        $imagePath = new UrlImage($url);

        $this->assertEquals('mf.jpg', $imagePath->obtainFileName());
    }

}
