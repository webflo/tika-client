<?php

class TikaWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        //$this->client = $this->getMock('\TikaClient', array('runProcess'));
        $this->client = new TikaClient();
        $this->resource = __DIR__ . '/files/doc.doc';
    }

    public function testConstructor()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $this->assertAttributeEquals($this->resource, 'resource', $doc);
        $this->assertAttributeEquals($this->client, 'client', $doc);        
    }

    public function testGetContent()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $content = $doc->getText();        
        $this->assertEquals(file_get_contents(__DIR__ . '/files/doc.txt'), $content);
    }

    public function testGetContentHtml()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $content = $doc->getHtml();
        $this->assertEquals(file_get_contents(__DIR__ . '/files/doc.html'), $content);
    }

    public function testGetMetadata()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $metadata = $doc->getMetadata();
        $this->assertInternalType('array', $metadata);
    }

    public function testGetContentType()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $type = $doc->getContentType();
        $this->assertEquals('application/msword', $type);
    }

    public function testExtractTo()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $dir = sys_get_temp_dir() . '/' . md5(time()) . '_tikaxtract';
        $file = $dir . '/' . time() . '.html';
        mkdir($dir);
        $doc->extractTo($file, true);

        $this->assertFileExists($file);
        $this->assertFileExists($dir . '/image1.png');        
    }

    public function testExtractToTxt()
    {
        $doc = new TikaWrapper($this->resource, $this->client);
        $dir = sys_get_temp_dir() . '/' . md5(time()) . '_tikaxtract';
        $file = $dir . '/' . time() . '.txt';
        mkdir($dir);
        $doc->extractTo($file, false);

        $this->assertFileExists($file);
        $this->assertFileNotExists($dir . '/image1.png');        
    }    

    public function testFixEmbedded()
    {
        $doc = new TikaWrapper($this->resource, $this->client);        
        $html = '<img src="embedded:image1.png">';
        $fixed = $doc->fixEmbedded($html);
        $this->assertEquals('<img src="image1.png">', $fixed);
    }
}