<?php


namespace Odango\Hebo\Nyaa\Crawler;


class PageInfo
{
    private $title;
    private $submitterName;
    private $submitterId;
    private $categoryId;
    private $torrentId;

    /**
     * @return mixed
     */
    public function getTorrentId()
    {
        return $this->torrentId;
    }

    /**
     * @param mixed $torrentId
     */
    public function setTorrentId($torrentId)
    {
        $this->torrentId = $torrentId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSubmitterName()
    {
        return $this->submitterName;
    }

    /**
     * @param mixed $submitterName
     */
    public function setSubmitterName($submitterName)
    {
        $this->submitterName = $submitterName;
    }

    /**
     * @return mixed
     */
    public function getSubmitterId()
    {
        return $this->submitterId;
    }

    /**
     * @param mixed $submitterId
     */
    public function setSubmitterId($submitterId)
    {
        $this->submitterId = $submitterId;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
}