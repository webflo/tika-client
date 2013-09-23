<?php

class TikaClientTest extends \PHPUnit_Framework_TestCase
{
    protected $jarFile;

    public function setUp()
    { 
        $this->jarFile = realpath(__DIR__ . '/../bin/tika-app-1.4.jar');
    }

    public function testConstruct()
    {   
        $tika = new TikaClient();                
        $this->assertObjectHasAttribute('endPoint', $tika);        
        $this->assertAttributeEquals(null, 'endPoint', $tika);        
        $this->assertEquals($this->jarFile, $tika->getEndPoint());
    }    

    public function testConstructEndPoint()
    {
        $jarFile = $this->jarFile . '.custom';
        $tika = new TikaClient($jarFile);
        $this->assertAttributeEquals($jarFile, 'endPoint', $tika);
        $this->assertEquals($jarFile, $tika->getEndPoint());

        $url = 'http://localhost:8080';
        $tika = new TikaClient($url);
        $this->assertAttributeEquals($url, 'endPoint', $tika);
        $this->assertEquals($url, $tika->getEndPoint());
    }

    public function testGetContent()
    {
        $tika = new TikaClient();    
        $text = $tika->getXhtml(__DIR__ . '/files/doc.doc');
        $this->assertEquals(file_get_contents(__DIR__ . '/files/doc.xhtml'), $text);
    }

    public function testGetContentHtml()
    {
        $tika = new TikaClient();    
        $text = $tika->getHtml(__DIR__ . '/files/doc.doc');
        $this->assertEquals(file_get_contents(__DIR__ . '/files/doc.html'), $text);
    }

    public function testGetContentRawText()
    {
        $tika = new TikaClient();    
        $text = $tika->getText(__DIR__ . '/files/doc.doc');
        //file_put_contents(__DIR__ . '/files/doc.txt', $text);
        $this->assertEquals(file_get_contents(__DIR__ . '/files/doc.txt'), $text);
    }

    public function testGetMetadataJson()
    {
        $tika = new TikaClient();    
        $metadata = $tika->getMetadata(__DIR__ . '/files/doc.doc', 'json');
        $this->assertInternalType('array', $metadata);
        $this->assertArrayHasKey('title', $metadata);
        $this->assertEquals('Documento sem título.docx', $metadata['title']);
    }     

    public function testDetectType()
    {
        $tika = new TikaClient();
        $doc = $tika->getContentType(__DIR__ . '/files/doc.doc');
        $this->assertEquals('application/msword', $doc);

        $pdf = $tika->getContentType(__DIR__ . '/files/doc.pdf');
        $this->assertEquals('application/pdf', $pdf);
    }

    public function testExtractAttachments()
    {
        $tika = new TikaClient();
        $dir = sys_get_temp_dir(); 
        @unlink($dir . '/image1.png');
        $tika->extract(__DIR__ . '/files/doc.doc', $dir);
        $this->assertFileExists($dir . '/image1.png');
    }
}