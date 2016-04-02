<?php

require_once __DIR__ . '/../autoload.php';

class FunctionResizeTest extends PHPUnit_Framework_TestCase
{
    public function testsanitize()
    {
        $url = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php%20define%20dictionary';
        $expected = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php define dictionary';
        
        $this->assertEquals($expected, sanitize($url));
    }
}

?>
