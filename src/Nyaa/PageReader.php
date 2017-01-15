<?php


namespace Odango\Hebi\Nyaa;


use DOMWrap\Document;
use DOMWrap\Element;
use Odango\Hebi\Nyaa\Reader;
use Symfony\Component\Validator\Tests\Fixtures\Countable;

class PageReader extends Reader
{
    public function extractInfo(): PageInfo {
        $pageInfo = new PageInfo();
        $pageInfo->setSource($this->getSource());

        if (!$this->parseIsFound()) {
            $pageInfo->setIsFound(false);
            return $pageInfo;
        }

        $pageInfo->setIsFound(true);
        $pageInfo->setTitle($this->parseTitle());
        $pageInfo->setSubmitterName($this->parseSubmitterName());
        $pageInfo->setSubmitterId($this->parseSubmitterId());
        $pageInfo->setCategoryId($this->parseCategoryId());
        $pageInfo->setTorrentId($this->parseTorrentId());

        return $pageInfo;
    }

    public function parseTitle(): string {
        $title = $this->getDocument()->find('.viewtorrentname')->first();

        if ($title !== null) {
            return $title->getText();
        }

        return "";
    }

    private function getSubmitterTableField(): Element {
        return $this->getDocument()->find('.tname:contains("Submitter")')->following();
    }

    public function parseSubmitterName(): string {
        return $this->getSubmitterTableField()->find('a')->first()->getText();
    }

    public function parseSubmitterId(): int
    {
        /** @var Element $a */
        $a = $this->getSubmitterTableField()->find('a')->first();

        if ($a === null) {
            return -1;
        }

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

    public function parseIsFound() {
        return $this->getDocument()->find('img[alt="Download"]')->count() > 0;
    }
}