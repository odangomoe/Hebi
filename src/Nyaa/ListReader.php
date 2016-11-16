<?php


namespace Odango\Hebi\Nyaa;


class ListReader extends Reader
{
    public function getHighestId() {
        $href = $this->getDocument()->find('.tlist .tlistname a')->first()->attr('href');
        return intval($this->getQueryItemFromUrl($href, 'tid'));
    }
}