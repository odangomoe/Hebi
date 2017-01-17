<?php


namespace Odango\Hebi\AniDB;

use Odango\Hebi\Reader;

/**
 * Class DumpReader
 * @package Odango\Hebi\AniDB
 */
class DumpReader extends Reader
{
    /**
     * @var \DOMNode
     */
    private $current;

    /**
     * @return \DOMNode
     */
    public function getNextItem() {
        if ($this->current == null) {
            $this->current = $this->getDocument()->find('animetitles')[0]->childNodes[0];
        } else {
            $this->current = $this->current->nextSibling;
        }

        return $this->current;
    }

    /**
     * @return TitleCollection
     */
    public function getNextTitleCollection() {
        $item = $this->getNextItem();
        if ($item === null) {
            return null;
        }

        return TitleCollection::createFromNode($item);
    }

    /**
     * @return TitleCollection[]
     */
    public function getAllTitleCollections(): array {
        $items = [];
        while (($item =$this->getNextTitleCollection()) !== null) {
            $items[] = $item;
        }

        return $items;
    }
}