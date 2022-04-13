<?php
namespace App\Entity;

use App\Helper\DirectoryHelper;
use App\Entity\MetadataObject;

/** @Entity */
class Video
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    // ...
    /**
     * Many features have one page. This is the owning side.
     * @ManyToOne(targetEntity="Page", inversedBy="page")
     * @JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;
    
    /** @Column(length=1024) */
    private $url;

    /** @Column(type="datetime",nullable=true) */
    private $fetchedTime;

    /** @Column(type="boolean") */
    private $grabbed_html = false;

    /** @Column(type="boolean") */
    private $downloaded_video = false;
    
    /** @Column(length=124) */
    private $downloaded_qualtity = false;

    /** @Column(length=16,nullable=true)) */
    private $openSubtitlesHash = false;
    
    /** @Column(type="object",nullable=true) */
    private $metadata;

    /** @Column(length=1024,nullable=true) */
    private $fileNameSaved = "";

    
    private $download_url = "";
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
     * Undocumented function
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @return self
     */
    public function setPage($page) : self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return self
     */
    public function setUrl($url) : self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of fetchedTime
     */
    public function getFetchedTime()
    {
        return $this->fetchedTime;
    }


    /**
     * Set the value of fetchedTime
     *
     * @return self
     */
    public function setFetchedTime($fetchedTime) : self
    {
        $this->fetchedTime = $fetchedTime;

        return $this;
    }

    /**
     * Get the value of grabbed_html
     */
    public function getGrabbedHtml()
    {
        return $this->grabbed_html;
    }

    /**
     * Set the value of grabbed_html
     *
     * @return self
     */
    public function setGrabbedHtml($grabbed_html) : self
    {
        $this->grabbed_html = $grabbed_html;

        return $this;
    }

    /**
     * Get the value of downloaded_qualtity
     */
    public function getDownloadedQualtity()
    {
        return $this->downloaded_qualtity;
    }

    /**
     * Set the value of downloaded_qualtity
     *
     * @return self
     */
    public function setDownloadedQualtity($downloaded_qualtity) : self
    {
        $this->downloaded_qualtity = $downloaded_qualtity;

        return $this;
    }


    /**
     * Undocumented function
     *
     * @return MetadataObject
     */
    public function getMetadata()
    {
        return  $this->metadata;
    }

    /**
     * Set the value of metadata
     *
     * @return self
     */
    public function setMetadata($metadata) : self
    {
        $this->metadata = clone $metadata;

        return $this;
    }

    /**
     * Get the value of downloaded_video
     */
    public function getDownloadedVideo()
    {
        return $this->downloaded_video;
    }

    /**
     * Set the value of downloaded_video
     *
     * @return self
     */
    public function setDownloadedVideo($downloaded_video) : self
    {
        $this->downloaded_video = $downloaded_video;

        return $this;
    }

    /**
     * Get the value of download_url
     */
    public function getDownloadUrl()
    {
        return $this->download_url;
    }

    /**
     * Set the value of download_url
     *
     * @return self
     */
    public function setDownloadUrl($download_url) : self
    {
        $this->download_url = $download_url;

        return $this;
    }


    public function getFilename() : string {
        $meta  = $this->getMetadata();
        $name = $meta->getSceneName();
        if(count($meta->getPerformers()) > 0) {
            $wroteLead = false;
            foreach ($meta->getPerformers() as $key => $performerName) {
                if(!str_contains($name,$performerName)) {
                    if(!$wroteLead) {
                        $name .= " - ".$performerName;
                        $wroteLead = true;
                    } else {
                        $name .= ", ".$performerName;
                    }
                    
                }
            }
        }
        if($meta->getDate() !== null) {
            $name .=" - ". $meta->getDate()->format('Y.m.d');
        }
        $extension = explode('.',$this->getDownloadUrl());
        $extension = end($extension);
        $extension = explode("?",$extension)[0];
        if(str_contains($extension,'/')) {
            $extension = "mp4";
        }
        if(str_contains($extension,'m3u8')) {
            $extension = "ts";
        }
        if(str_contains('/',$name)) {
            $name = str_replace('/',' ',$name);
        }
        if($name )
        return $name.".".$extension;
    }

    public function getFilePath() : string {
        return DirectoryHelper::getRealPath('videos').$this->getFilename();
    }

    public function getSavedFilePath() : ?string {
        return DirectoryHelper::getRealPath('videos').$this->getFileNameSaved();
    }


    public function getPublicUrl() : string {

        $parser = $this->getPage()->getCommandClass()->getMetadataParser();
        return $parser->getPublicUrl($this);
    }
    /**
     * Get the value of fileNameSaved
     */
    public function getFileNameSaved() : ?string
    {
        return $this->fileNameSaved;
    }

    /**
     * Set the value of fileNameSaved
     *
     * @return self
     */
    public function setFileNameSaved($fileNameSaved) : self
    {
        $this->fileNameSaved = $fileNameSaved;

        return $this;
    }

    /**
     * Get the value of openSubtitlesHash
     */
    public function getOpenSubtitlesHash() : ?string
    {
        return $this->openSubtitlesHash;
    }

    /**
     * Set the value of openSubtitlesHash
     *
     * @return self
     */
    public function setOpenSubtitlesHash($openSubtitlesHash) : self
    {
        $this->openSubtitlesHash = $openSubtitlesHash;

        return $this;
    }
}