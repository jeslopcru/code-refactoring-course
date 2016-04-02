<?php

require_once __DIR__ . '/../autoload.php';


class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    private $defaults = array(
        'crop' => false,
        'scale' => 'false',
        'thumbnail' => false,
        'maxOnly' => false,
        'canvas-color' => 'transparent',
        'output-filename' => false,
        'cacheFolder' => './cache/',
        'remoteFolder' => './cache/remote/',
        'quality' => 90,
        'cache_http_minutes' => 20,
        'width' => null,
        'height' => null
    );
    /** @var Configuration */
    private $defaultConfiguration;

    public function testOpts()
    {
        $this->assertInstanceOf('Configuration', new Configuration);
    }

    public function testNullOptsDefaults()
    {
        $configuration = new Configuration(null);

        $this->assertEquals($this->defaults, $configuration->asHash());
    }

    public function testDefaults()
    {
        $asHash = $this->defaultConfiguration->asHash();

        $this->assertEquals($this->defaults, $asHash);
    }

    public function testDefaultsNotOverwriteConfiguration()
    {

        $opts = array(
            'thumbnail' => true,
            'maxOnly' => true
        );

        $configuration = new Configuration($opts);
        $configured = $configuration->asHash();

        $this->assertTrue($configured['thumbnail']);
        $this->assertTrue($configured['maxOnly']);
    }

    public function testObtainCache()
    {
        $this->assertEquals('./cache/', $this->defaultConfiguration->obtainCache());
    }

    public function testObtainRemote()
    {
        $this->assertEquals('./cache/remote/', $this->defaultConfiguration->obtainRemote());
    }

    public function testObtainConvertPath()
    {
        $this->assertEquals('convert', $this->defaultConfiguration->obtainConvertPath());
    }

    public function testObtainWidth()
    {
        $this->assertEquals(null, $this->defaultConfiguration->obtainWidth());

        $valueExpected = 100;
        $configuration = new Configuration(['width' => $valueExpected]);
        $this->assertEquals($valueExpected, $configuration->obtainWidth());
    }

    public function testObtainHeight()
    {
        $this->assertEquals(null, $this->defaultConfiguration->obtainHeight());

        $valueExpected = 100;
        $configuration = new Configuration(['height' => $valueExpected]);
        $this->assertEquals($valueExpected, $configuration->obtainHeight());
    }

    protected function setUp()
    {
        $this->defaultConfiguration = new Configuration();
    }
}
