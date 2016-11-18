<?php

namespace Odango\Hebi\AniDB;

class TitleCollection
{
    /**
     * @var int
     */
    private $aid;

    /**
     * @var Title[]
     */
    private $titles;

    public function createFromNode(\DOMNode $node) {
        $this->aid = $node['@aid'];
    }
}