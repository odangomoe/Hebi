<?php


namespace Odango\Hebi\Nyaa;


use DOMWrap\Document;

abstract class Reader
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var Document
     */
    protected $document;

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        if ($this->document == null) {
            $this->setDocument(new Document());
        }

        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source ?? "";
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->getDocument()->setHtml($source);
        $this->source = $source;
    }

    static public function createFromSource($source): Reader {
        $reader = new static();
        $reader->setSource($source);
        return $reader;
    }


    protected function getQueryItemFromUrl($url, $queryItem, $default = null) {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $queryItems);

        return $queryItems[$queryItem] ?? $default;
    }
}