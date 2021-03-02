<?php
namespace App\Entity;

use DateTime;

class MetadataObject {
    private $actress;

    /** @var string[] */
    private $tags =[];


    private $scene_name;

    private $date;

    private $BehindeTheScenes = false;
    private $thumbnail_url;

    private $description;
    
    function __construct()
    {
        
    }

    /**
     * Get the value of tags
     *
     * @return array
     */
    public function getTags() : array 
    {
        if(is_array($this->tags)) {
            return $this->tags;
        } else {
            return [];
        }
    }

    /**
     * Set the value of tags
     *
     * @param array $tags
     *
     * @return self
     */
    public function setTags(array $tags) : self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get the value of scene_name
     *
     * @return string
     */
    public function getSceneName() : string 
    {
        return $this->scene_name;
    }

    /**
     * Set the value of scene_name
     *
     * @param string $scene_name
     *
     * @return self
     */
    public function setSceneName(string $scene_name) : self
    {
        $this->scene_name = $scene_name;

        return $this;
    }

    /**
     * Get the value of date
     *
     * @return string
     */
    public function getDate() : DateTime 
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param string $date
     *
     * @return self
     */
    public function setDate(DateTime $date) : self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of thumbnail_url
     *
     * @return string
     */
    public function getThumbnailUrl() : string 
    {
        return $this->thumbnail_url;
    }

    /**
     * Set the value of thumbnail_url
     *
     * @param string $thumbnail_url
     *
     * @return self
     */
    public function setThumbnailUrl(string $thumbnail_url) : self
    {
        $this->thumbnail_url = $thumbnail_url;

        return $this;
    }

    /**
     * Get the value of actress
     *
     * @return string
     */
    public function getActress() : string 
    {
        return $this->actress;
    }

    /**
     * Set the value of actress
     *
     * @param string $actress
     *
     * @return self
     */
    public function setActress(string $actress) : self
    {
        $this->actress = $actress;

        return $this;
    }

    /**
     * Get the value of BehindeTheScenes
     *
     * @return bool
     */
    public function getBehindeTheScenes() : bool 
    {
        if(isset($this->BehindeTheScenes) {
            return $this->BehindeTheScenes;
        }
        return false;
    }

    /**
     * Set the value of BehindeTheScenes
     *
     * @param bool $BehindeTheScenes
     *
     * @return self
     */
    public function setBehindeTheScenes(bool $BehindeTheScenes) : self
    {
        $this->BehindeTheScenes = $BehindeTheScenes;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return self
     */
    public function setDescription($description) : self
    {
        $this->description = $description;

        return $this;
    }
}