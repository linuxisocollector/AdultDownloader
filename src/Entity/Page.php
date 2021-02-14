<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Page
{
    // ...
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Video", mappedBy="video")
     */
    private $videos;

    /** 
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * */
    private $id;
    /** @Column(length=140) */
    private $name;
    /** @Column(type="datetime") */
    private $updated;

    public function __construct() {
        $this->features = new ArrayCollection();
    }

    /**
     * Get the value of videos
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set the value of videos
     *
     * @return self
     */
    public function setVideos($videos) : self
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return self
     */
    public function setId($id) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return self
     */
    public function setName($name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of updated
     *
     * @return self
     */
    public function setUpdated($updated) : self
    {
        $this->updated = $updated;

        return $this;
    }
}

