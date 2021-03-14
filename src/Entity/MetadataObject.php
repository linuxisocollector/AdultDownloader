<?php
namespace App\Entity;

use App\Helper\LoggerHelper;
use DateTime;
use Throwable;

class MetadataObject {
    private $performers;
    /** @var string[] */
    private $tags =[];


    private $scene_name;

    private $date;

    private $BehindeTheScenes = false;
    private $thumbnail_url;
    private $publicSceneUrl;

    private $studio;
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
     * Undocumented function
     *
     * @return string[]
     */
    public function getPerformers() {
        return $this->performers;
    }
    /**
     * Undocumented function
     *
     * @param string[] $performers
     * @return self
     */
    public function setPerformers($performers) :self {
        $this->performers = $performers;
        return $this;
    }
    /**
     * Get the value of BehindeTheScenes
     *
     * @return bool
     */
    public function getBehindeTheScenes() : bool 
    {
        if(isset($this->BehindeTheScenes)) {
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

    public function combineMetadata(MetadataObject $metadataForeign) : self {
        $methods = get_class_methods($this::class);
        $sortedMethods = [];
        foreach ($methods as $key => $method) {
            if(str_starts_with($method,'set')) {
                $getMethod = str_replace('set','get',$method);
                if(in_array(str_replace('set','get',$method),$methods)) {
                    $sortedMethods[$getMethod] = [
                        'get' => $getMethod,
                        'set' => $method
                    ];
                }
            } elseif(str_starts_with($method,'get')) {
                $setMethod = str_replace('get','set',$method);
                if(in_array(str_replace('get','set',$method),$methods)) {
                    $sortedMethods[$method] = [
                        'get' => $method,
                        'set' => $setMethod
                    ];
                }
            }
        }
        foreach ($sortedMethods as $key => $getterSetterMethod) {
            $getMethod = $getterSetterMethod['get'];
            $setMethod = $getterSetterMethod['set'];
            try {
                $foreignValue = $metadataForeign->$getMethod();
            } catch(Throwable $e) {
                continue;
            }
            $thisValue = $this->$getMethod();
            if(
                ($thisValue === null && $foreignValue !== null) ||
                (is_string($thisValue) && is_string($foreignValue) && $foreignValue !== "" && $thisValue !== $foreignValue) ||
                (is_array($thisValue) && is_array($foreignValue) && count($thisValue) <= count($foreignValue) && count($foreignValue) > 0 ) && count(array_diff($thisValue,$foreignValue)) > 0 ||
                (is_bool($thisValue) && false)
            ) {
                $this->$setMethod($foreignValue);
                LoggerHelper::writeToConsole("Updated ".json_encode($thisValue)." by setting ".json_encode($foreignValue)." for scene ".$this->getSceneName(),'verbose');
            }
        }

        return $this;
    }

    /**
     * Get the value of studio
     */
    public function getStudio() : ?string
    {
        return $this->studio;
    }

    /**
     * Set the value of studio
     *
     * @return self
     */
    public function setStudio($studio) : self
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * Get the value of publicSceneUrl
     */
    public function getPublicSceneUrl()
    {
        return $this->publicSceneUrl;
    }

    /**
     * Set the value of publicSceneUrl
     *
     * @return self
     */
    public function setPublicSceneUrl($publicSceneUrl) : self
    {
        $this->publicSceneUrl = $publicSceneUrl;

        return $this;
    }
}