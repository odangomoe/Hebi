<?php

namespace Odango\Hebi\AniDB;

class Title
{
    /**
     * @var bool
     */
    private $isMain = false;

    /**
     * @var string
     */
    private $name;

    /**
     * @return boolean
     */
    public function isMain(): bool
    {
        return $this->isMain;
    }

    /**
     * @param boolean $isMain
     */
    public function setIsMain(bool $isMain)
    {
        $this->isMain = $isMain;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    static public function isAcceptable(\DOMNode $node) {
        $lang = $node->attributes->getNamedItem('xml:lang');
        $langValue = $lang === null ? "" : $lang->textContent;
        return in_array($langValue, ["en", "x-jat"]);
    }

    static public function createFromNode(\DOMNode $node): Title {
        $title = new Title();
        $type = $node->attributes->getNamedItem('type');
        if ($type === null) {
            $title->setIsMain(false);
        } else {
            $title->setIsMain($type->value === 'main');
        }

        $title->setName($node->textContent);

        return $title;
    }
}