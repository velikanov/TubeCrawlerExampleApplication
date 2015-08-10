<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Model;

/**
 * TubeCrawler tube model.
 *
 * @author Serge Velikanov <me@velikanov.pro>
 *
 * @package Velikan\Component\TubeCrawler\Model
 */
class Tube
{
    const HTTP_SCHEME = 0;
    const HTTPS_SCHEME = 1;

    public static $schemeList = [
        self::HTTP_SCHEME => 'http',
        self::HTTPS_SCHEME => 'https',
    ];

    /**
     * Tube id
     *
     * @var mixed
     */
    protected $id;

    /**
     * Tube name
     *
     * @var string
     */
    protected $name;

    /**
     * Tube URI scheme
     *
     * @var int
     */
    protected $scheme = Tube::HTTP_SCHEME;

    /**
     * Tube URI host
     *
     * @var string
     */
    protected $host;

    /**
     * Tube URN
     *
     * @var string
     */
    protected $urn;

    /**
     * Tube videos list starting page number
     *
     * @var int
     */
    protected $startingPageNumber = 1;

    /**
     * Can videos be fetched in multi-thread
     *
     * @var boolean
     */
    protected $canFetchMultithreaded = false;

    /**
     * Multithreaded fetch threads count
     *
     * @var int
     */
    protected $threadCount = 1;

    /**
     * Videos page video block selector
     *
     * @var string
     */
    protected $videoBlockSelector;

    /**
     * Videos page video URI selector
     *
     * @var string
     */
    protected $videoUriSelector;

    /**
     * Videos page video image selector
     *
     * @var string
     */
    protected $videoImageSelector;

    /**
     * Videos page video title selector
     *
     * @var string
     */
    protected $videoTitleSelector;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Tube
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param int $scheme
     * @return Tube
     */
    public function setScheme($scheme)
    {
        if (!array_key_exists($scheme, self::$schemeList)) {
            $scheme = self::HTTP_SCHEME;
        }

        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Tube
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrn()
    {
        return $this->urn;
    }

    /**
     * @param string $urn
     * @return Tube
     */
    public function setUrn($urn)
    {
        $this->urn = $urn;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStartingPageNumber()
    {
        return $this->startingPageNumber;
    }

    /**
     * @param mixed $startingPageNumber
     *
     * @return Tube
     */
    public function setStartingPageNumber($startingPageNumber)
    {
        $this->startingPageNumber = $startingPageNumber;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCanFetchMultithreaded()
    {
        return $this->canFetchMultithreaded;
    }

    /**
     * @param boolean $canFetchMultithreaded
     */
    public function setCanFetchMultithreaded($canFetchMultithreaded)
    {
        $this->canFetchMultithreaded = $canFetchMultithreaded;
    }

    /**
     * @return int
     */
    public function getThreadCount()
    {
        return $this->threadCount;
    }

    /**
     * @param int $threadCount
     */
    public function setThreadCount($threadCount)
    {
        $this->threadCount = $threadCount;
    }

    /**
     * @return string
     */
    public function getVideoBlockSelector()
    {
        return $this->videoBlockSelector;
    }

    /**
     * @param string $videoBlockSelector
     * @return Tube
     */
    public function setVideoBlockSelector($videoBlockSelector)
    {
        $this->videoBlockSelector = $videoBlockSelector;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoUriSelector()
    {
        return $this->videoUriSelector;
    }

    /**
     * @param string $videoUriSelector
     * @return Tube
     */
    public function setVideoUriSelector($videoUriSelector)
    {
        $this->videoUriSelector = $videoUriSelector;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoImageSelector()
    {
        return $this->videoImageSelector;
    }

    /**
     * @param string $videoImageSelector
     * @return Tube
     */
    public function setVideoImageSelector($videoImageSelector)
    {
        $this->videoImageSelector = $videoImageSelector;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideoTitleSelector()
    {
        return $this->videoTitleSelector;
    }

    /**
     * @param mixed $videoTitleSelector
     * @return Tube
     */
    public function setVideoTitleSelector($videoTitleSelector)
    {
        $this->videoTitleSelector = $videoTitleSelector;

        return $this;
    }


    /**
     * Get tube url
     *
     * @return string
     */
    public function getUrl()
    {
        return self::$schemeList[$this->getScheme()].'://'.$this->getHost();
    }

    /**
     * Get tube uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->getUrl().$this->getUrn();
    }

    public function __toString()
    {
        return $this->getName();
    }
}