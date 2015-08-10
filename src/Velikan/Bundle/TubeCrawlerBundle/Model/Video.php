<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Model;

/**
 * TubeCrawler video model.
 *
 * @author Serge Velikanov <me@velikanov.pro>
 *
 * @package Velikan\Component\TubeCrawler\Model
 */
class Video
{
    /**
     * Video id
     *
     * @var mixed
     */
    protected $id;

    /**
     * Tube
     *
     * @var Tube
     */
    protected $tube;

    /**
     * Video title
     *
     * @var string
     */
    protected $title;

    /**
     * Video URI on Tube
     *
     * @var string
     */
    protected $videoUri;

    /**
     * Video image URI
     *
     * @var string
     */
    protected $imageUri;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Tube
     */
    public function getTube()
    {
        return $this->tube;
    }

    /**
     * @param Tube $tube
     * @return Video
     */
    public function setTube($tube)
    {
        $this->tube = $tube;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoUri()
    {
        return $this->videoUri;
    }

    /**
     * @param string $videoUri
     * @return Video
     */
    public function setVideoUri($videoUri)
    {
        $this->videoUri = $videoUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUri()
    {
        return $this->imageUri;
    }

    /**
     * @param string $imageUri
     * @return Video
     */
    public function setImageUri($imageUri)
    {
        $this->imageUri = $imageUri;

        return $this;
    }


    public function __toString()
    {
        return $this->getTitle();
    }
}