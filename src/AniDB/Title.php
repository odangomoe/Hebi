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
    public function isIsMain(): bool
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
}