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
     * @var array
     */
    private $replace = [];

    /**
     * @param array $replace
     */
    public function setReplace(array $replace): void
    {
        $this->replace = $replace;
    }

    /**
     * @return TitleCollection[]
     */
    public function getAllTitleCollections(): array
    {
        $items = [];
        while (($item = $this->getNextTitleCollection()) !== null) {
            $items[] = $item;
        }

        return $items;
    }

    /**
     * @return TitleCollection
     */
    public function getNextTitleCollection()
    {
        $item = $this->getNextItem();
        if ($item === null) {
            return null;
        }

        return TitleCollection::createFromNode($item, $this->replace);
    }

    /**
     * @return \DOMNode
     */
    public function getNextItem()
    {
        if ($this->current == null) {
            $this->current = $this->getDocument()->find('animetitles')[0]->childNodes[0];
        } else {
            $this->current = $this->current->nextSibling;
        }

        while ($this->current !== null && $this->current->nodeName !== 'anime') {
            $this->current = $this->current->nextSibling;
        }

        return $this->current;
    }

    static public function createFromSourceWithReplace($source, $replace = [])
    {
        $reader = static::createFromSource($source);
        $reader->setReplace($replace);
        return $reader;
    }
}