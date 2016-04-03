<?php


class PathTest extends PHPUnit_Framework_TestCase
{
    private $root;

    public function testNewPath()
    {
        $configuration = new Configuration();
        $imageFile = org\bovigo\vfs\vfsStream::newFile('image.jpq')->at($this->root);
        $path = new Path($configuration);
        $this->assertEquals(
            './cache/d41d8cd98f00b204e9800998ecf8427e_sc.jpq',
            $path->composeNewPath($imageFile->url(), $configuration));

        $expectedPath = 'thiIsAExpectedPath';
        $configuration = new Configuration([Configuration::OUTPUTFILENAME_KEY => $expectedPath]);
        $path = new Path($configuration);

        $this->assertEquals(
            $expectedPath,
            $path->composeNewPath($imageFile->url())
        );
    }

    public function setUp()
    {
        $this->root = org\bovigo\vfs\vfsStream::setup();
    }

}
