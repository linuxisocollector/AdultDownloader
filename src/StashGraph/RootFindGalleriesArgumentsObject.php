<?php

namespace GraphQL\SchemaObject;

class RootFindGalleriesArgumentsObject extends ArgumentsObject
{
    protected $gallery_filter;
    protected $filter;

    public function setGalleryFilter(GalleryFilterTypeInputObject $galleryFilterTypeInputObject)
    {
        $this->gallery_filter = $galleryFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
