<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;

class VideoParser
{
    public function parse($responseBody, $blockSelector, $uriSelector, $imageSelector, $titleSelector)
    {
        $videos = [];

        $responseBodyCrawler = new Crawler($responseBody);

        $videoBlocks = $responseBodyCrawler->filter($blockSelector);

        /** @var \DOMElement $videoBlock */
        foreach ($videoBlocks as $videoBlock) {
            $videoBlockCrawler = new Crawler($videoBlock);

            $videoUriElement = $videoBlockCrawler->filter($uriSelector);
            $videoImageElement = $videoBlockCrawler->filter($imageSelector);
            $videoTitleElement = $videoBlockCrawler->filter($titleSelector);

            $videoUri = $videoUriElement->attr('href');
            $videoImage = $videoImageElement->attr('src');
            $videoTitle = $videoTitleElement->text();

            $video = [
                'uri' => $videoUri,
                'image' => $videoImage,
                'title' => $videoTitle,
            ];

            $videos[] = $video;

            unset($videoBlockCrawler);
        }

        unset($responseBodyCrawler);

        return $videos;
    }
}