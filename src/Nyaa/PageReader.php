<?php


namespace Odango\Hebo\Nyaa\Crawler;


use DOMWrap\Document;
use DOMWrap\Element;

class PageReader
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var Document
     */
    private $document;

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

    static public function createFromSource($source): PageReader {
        $pageReader = new static();
        $pageReader->setSource($source);
        return $pageReader;
    }

    public function extractInfo(): PageInfo {
        $pageInfo = new PageInfo();

        $pageInfo->setTitle($this->parseTitle());
        $pageInfo->setSubmitterName($this->parseSubmitterName());
        $pageInfo->setSubmitterId($this->parseSubmitterId());
        $pageInfo->setCategoryId($this->parseCategoryId());
        $pageInfo->setTorrentId($this->parseTorrentId());

        return $pageInfo;
    }

    public function parseTitle(): string {
        return $this->getDocument()->find('.viewtorrentname')->first()->getText();
    }

    private function getSubmitterTableField(): Element {
        return $this->getDocument()->find('.tname:contains("Submitter")')->following();
    }

    public function parseSubmitterName(): string {
        return $this->getSubmitterTableField()->find('a')->first()->getText();
    }

    private function getQueryItemFromUrl($url, $queryItem, $default = null) {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $queryItems);

        return $queryItems[$queryItem] ?? $default;
    }

    public function parseSubmitterId(): int
    {
        /** @var Element $a */
        $a = $this->getSubmitterTableField()->find('a')->first();

        $href = $a->attr('href');

        return intval($this->getQueryItemFromUrl($href, 'user', -1));
    }

    public function parseCategoryId() {
        $href = $this->getDocument()->find('.viewcategory > a')->last()->attr('href');

        return $this->getQueryItemFromUrl($href, 'cats');
    }

    public function parseTorrentId() {
        $href = $this->getDocument()->find('.viewdownloadbutton > a')->last()->attr('href');
        return intval($this->getQueryItemFromUrl($href, 'tid', -1));
    }
}