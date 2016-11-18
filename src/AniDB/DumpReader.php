<?php


namespace Odango\Hebi\AniDB;


class DumpReader
{
    /**
     * @var \DOMDocument
     */
    private $document;

    /**
     * @var string
     */
    private $source;

    /**
     * @return \DOMDocument
     */
    public function getDocument(): \DOMDocument
    {
        return $this->document;
    }

    /**
     * @param \DOMDocument $document
     */
    public function setDocument(\DOMDocument $document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($source);

        $this->document = $doc;
        $this->source = $source;
    }

    /**
     * @var \DOMNode
     */
    private $current;

    static public function createFromSource(string $source) {
        $dr = new static();
        $dr->setSource($source);

        return $dr;
    }
}