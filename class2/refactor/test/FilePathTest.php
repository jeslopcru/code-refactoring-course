<?php


class FilePathTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNecessaryCollaboration()
    {
        $resizer = new FilePath('anyNonPathObject');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOptionalCollaboration()
    {
        $resizer = new FilePath(new UrlImage(''), 'nonConfigurationObject');
    }

    public function testInstantiation()
    {
        $options = [Configuration::OUTPUTFILENAME_KEY => 'filename'];
        $this->assertInstanceOf('FilePath', new FilePath(new UrlImage(''), new Configuration($options)));
    }

    public function testObtainLocallyCachedFilePath()
    {
        $configuration = new Configuration(array('width' => 800, 'height' => 600));
        $imagePath = new UrlImage('http://martinfowler.com/mf.jpg?query=hello&s=fowler');
        $resizer = new FilePath($imagePath, $configuration);

        $stub = $this->getMockBuilder('FileSystem')
            ->getMock();
        $stub->method('file_get_contents')
            ->willReturn('foo');

        $stub->method('file_exists')
            ->willReturn(true);

        $resizer->injectFileSystem($stub);

        $this->assertEquals('./cache/remote/mf.jpg', $resizer->obtainFilePath());

    }

    public function testLocallyCachedFilePathFail()
    {
        $configuration = new Configuration(array('width' => 800, 'height' => 600));
        $imagePath = new UrlImage('http://martinfowler.com/mf.jpg?query=hello&s=fowler');
        $resizer = new FilePath($imagePath, $configuration);

        $stub = $this->getMockBuilder('FileSystem')
            ->getMock();
        $stub->method('file_exists')
            ->willReturn(true);

        $stub->method('filemtime')
            ->willReturn(21 * 60);

        $resizer->injectFileSystem($stub);

        $this->assertEquals('./cache/remote/mf.jpg', $resizer->obtainFilePath());

    }

    public function testCreateNewPath()
    {
        $configuration =  new Configuration([Configuration::OUTPUTFILENAME_KEY => 'filename']);
        $resizer = new FilePath(new UrlImage('http://martinfowler.com/mf.jpg?query=hello&s=fowler'), $configuration);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testFilePathNotExists()
    {
        $configuration = new Configuration(array('width' => 800, 'height' => 600));
        $imagePath = new UrlImage('http://martinfowler.com/mf.jpg?query=hello&s=fowler');
        $resizer = new FilePath($imagePath, $configuration);

        $stub = $this->getMockBuilder('FileSystem')
            ->getMock();
        $stub->method('file_exists')
            ->willReturn(false);

        $stub->method('filemtime')
            ->willReturn(21 * 60);

        $resizer->injectFileSystem($stub);

        $this->assertEquals('./cache/remote/mf.jpg', $resizer->obtainFilePath());
    }

}
