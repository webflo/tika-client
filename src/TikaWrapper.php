<?php

class TikaWrapper
{
    /**
     * File or URL to document
     *
     * @var string
     */
    protected $resource;

    /**
     * @var \TikaClient
     */
    protected $client;

    /**
     * Content cache
     * @var array
     */
    protected $content = array();

    /**
     * Metadata cache
     * @var array
     */
    protected $metadata = array();

    /**
     * Type cache
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $language;

    /**
     * @param string $resource
     * @param \TikaClient $client
     */
    public function __construct($resource, TikaClient $client = null)
    {
        $this->resource = $resource;
        $this->client   = $client;
    }

    /**
     * Lazy load TikaClient
     *
     * @return \TikaClient
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new TikaClient();
        }

        return $this->client;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->getClient()->getText($this->resource);
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->getClient()->getHtml($this->resource);
    }

    /**
     * @return string
     */
    public function getXhtml()
    {
        return $this->getClient()->getXhtml($this->resource);
    }

    /**
     * @param  string $format
     * @return string
     */
    public function getMetadata()
    {
        return $this->getClient()->getMetadata($this->resource);
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->getClient()->getContentType($this->resource);
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->getClient()->getLanguage($this->resource);
    }    
}