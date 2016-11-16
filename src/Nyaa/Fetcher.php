<?php


namespace Odango\Hebi\Nyaa;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class Fetcher
{
    private $container;
    private $curl;
    private $guzzleHandler;

    public function __construct($container)
    {
        $this->container = $container;
        $this->curl = new CurlMultiHandler();
        $this->guzzleHandler = HandlerStack::create($this->curl);
    }

    /**
     * @return Client
     */
    public function getGuzzleClient(): Client {
        return $this->container['guzzle'];
    }

    public function getSite() {
        return $this->container['config']['nyaa']['site'];
    }

    public function fetchHighestId(): PromiseInterface {
        $client = $this->getGuzzleClient();
        return $client->getAsync($this->getSite(), [
            'handler' => $this->guzzleHandler
        ])->then(function(ResponseInterface $response) {
            $listReader = ListReader::createFromSource($response->getBody()->getContents());
            return $listReader->getHighestId();
        });
    }

    public function fetchPageInfo($torrentId) {
        $client = $this->getGuzzleClient();

        return $client->getAsync($this->getSite() . '/?page=view&tid=' . $torrentId, [
                'handler' => $this->guzzleHandler
            ])->then(function (ResponseInterface $response) {
            $pageReader = PageReader::createFromSource($response->getBody()->getContents());
            return $pageReader->extractInfo();
        });
    }

    public function fetchTorrent($torrentId) {
        $client = $this->getGuzzleClient();

        return $client->getAsync($this->getSite() . '/?page=download&tid=' . $torrentId, [
            'handler' => $this->guzzleHandler
        ])->then(function (ResponseInterface $response) {
            return $response->getBody();
        });
    }

    public function tick() {
        $this->curl->tick();
    }
}