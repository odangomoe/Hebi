<?php

namespace Odango\Hebi\AniDB;

class TitleCollection
{
    /**
     * @var int
     */
    private $animeId;

    /**
     * @return int
     */
    public function getAnimeId(): int
    {
        return $this->animeId;
    }

    /**
     * @var Title[]
     */
    private $titles= [];

    /**
     * @return Title[]
     */
    public function getTitles(): array
    {
        return $this->titles;
    }

    static public function createFromNode(\DOMNode $node) {
        $col = new static();
        /** @var \DOMAttr $animeIdAttr */
        $animeIdAttr = $node->attributes['aid'];
        $col->animeId = $animeIdAttr->value;

        foreach ($node->childNodes as $child) {
            if(Title::isAcceptable($child)) {
                $col->titles[] = Title::createFromNode($child);
            }
        }

        return $col;
    }

    /** @var Title */
    private $mainTitle;

    public function getMainTitle() {
        if ($this->mainTitle !== null) {
            return $this->mainTitle;
        }

        foreach ($this->titles as $title) {
            if ($title->isMain()) {
                $this->mainTitle = $title;
                return $this->mainTitle;
            }
        }

        return $this->titles[0] ?? null;
    }

    public function getMainTitleName() {
        $title = $this->getMainTitle();

        if ($title === null) {
            return null;
        }

        return $title->getName();
    }
}