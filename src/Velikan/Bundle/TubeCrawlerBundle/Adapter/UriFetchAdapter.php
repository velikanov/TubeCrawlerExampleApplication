<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Adapter;

use Buzz\Browser;
use Guzzle\Service\Client;

class UriFetchAdapter
{
    private $guzzle;
    private $buzz;
    private $uriList = [];

    public function __construct(Client $guzzle, Browser $buzz)
    {
        $this->guzzle = $guzzle;
        $this->buzz = $buzz;
    }

    public function addUri($uri)
    {
        $this->uriList[] = $uri;
    }

    public function fetch($responseFunction, $isMultithreaded = false, $threadCount = 1)
    {
        if ($isMultithreaded) {

        } else {
            foreach ($this->uriList as $uri) {
                $response = $this->buzz->get($uri);
            }
        }
    }
}