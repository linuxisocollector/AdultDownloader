<?php

namespace GraphQL\SchemaObject;

class RootFindImagesArgumentsObject extends ArgumentsObject
{
    protected $image_filter;
    protected $image_ids;
    protected $filter;

    public function setImageFilter(ImageFilterTypeInputObject $imageFilterTypeInputObject)
    {
        $this->image_filter = $imageFilterTypeInputObject;

        return $this;
    }

    public function setImageIds(array $imageIds)
    {
        $this->image_ids = $imageIds;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
