<?php

namespace Odango\Hebi\AniDB;

use Odango\Hebi\Model\AnimeTitle;

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
     * @var AnimeTitle[]
     */
    private $titles= [];

    /**
     * @return AnimeTitle[]
     */
    public function getTitles(): array
    {
        return $this->titles;
    }

    static public function createFromNode(\DOMNode $node, $replace = []) {
        $col = new static();

        /** @var \DOMAttr $animeIdAttr */
        $animeIdAttr = $node->attributes['aid'];
        $col->animeId = $animeIdAttr->value;

        foreach ($node->childNodes as $child) {
            if ($child->nodeName !== 'title') {
                continue;
            }

            if(AnimeTitle::isAcceptable($child)) {
                $col->titles[] = AnimeTitle::createFromNode($child, $col->getAnimeId(), $replace);
            }
        }

        $col->cleanTitles();

        return $col;
    }

    private function cleanTitles() {
        $saved = [];
        $titles = [];
        $mainTitle = $this->getMainTitle();

        if ($mainTitle !== null) {
            $saved[] = $mainTitle;
            $titles[] = $mainTitle->getName();
        }

        foreach ($this->getTitles() as $title) {
            if (!in_array($title->getName(), $titles)) {
                $saved[] = $title;
                $titles[] = $title->getName();
            }
        }

        $this->titles = $saved;
    }

    /** @var AnimeTitle */
    private $mainTitle;

    public function getMainTitle() {
        if ($this->mainTitle !== null) {
            return $this->mainTitle;
        }

        foreach ($this->titles as $title) {
            if ($title->getMain()) {
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

    public function save($conn = null) {
        foreach ($this->getTitles() as $title) {
            $title->save($conn);
        }
    }
}