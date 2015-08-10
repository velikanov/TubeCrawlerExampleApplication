<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Adapter;

use Buzz\Browser;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class UriFetchAdapter
{
    private $guzzle;
    private $buzz;
    private $uriList = [];

    public function __construct(Browser $buzz)
    {
        $this->guzzle = new Client();
        $this->buzz = $buzz;
    }

    public function addUri($uri)
    {
        $this->uriList[] = $uri;
    }

    public function fetch($responseFunction, $isMultithreaded = false, $threadCount = 1)
    {
        if ($isMultithreaded) {
            $requestList = [];

            foreach ($this->uriList as $uri) {
                $requestList[] = new Request('GET', $uri);
            }

            $uriPool = new Pool($this->guzzle, $requestList, [
                'concurrency' => $threadCount,
                'fulfilled' => function(Response $response, $index) use ($responseFunction) {
                    $responseFunction($response->getBody()->getContents(), $index);
                },
                'rejected' => function() {

                }
            ]);

            $promise = $uriPool->promise();

            $promise->wait();
        } else {
            $parsedPageCounter = 0;

            foreach ($this->uriList as $uri) {
                $response = $this->buzz->get($uri);

                $responseFunction($response->getContent(), ++$parsedPageCounter);
            }
        }
    }
}