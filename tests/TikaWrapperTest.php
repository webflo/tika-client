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
}