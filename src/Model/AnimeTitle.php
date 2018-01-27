<?php

namespace Odango\Hebi\Model;

use Odango\Hebi\Model\Base\AnimeTitle as BaseAnimeTitle;

/**
 * Skeleton subclass for representing a row from the 'anime_title' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AnimeTitle extends BaseAnimeTitle
{
    static public function isAcceptable(\DOMNode $node) {
        $lang = $node->attributes->getNamedItem('xml:lang');
        $langValue = $lang === null ? "" : $lang->textContent;
        return in_array($langValue, ["en", "x-jat"]);
    }

    static public function createFromNode(\DOMNode $node, $animeId): AnimeTitle {
        $title = new AnimeTitle();
        $title->setAnimeId($animeId);
        /** @var \DOMNode|null $type */
        $type = $node->attributes->getNamedItem('type');
        if ($type === null) {
            $title->setMain(false);
        } else {
            $title->setMain($type->nodeValue === 'main');
        }
        $title->setName($node->textContent);

        return $title;
    }
}
