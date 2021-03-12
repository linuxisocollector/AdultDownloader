<?php

namespace GraphQL\SchemaObject;

class RootFindTagsArgumentsObject extends ArgumentsObject
{
    protected $tag_filter;
    protected $filter;

    public function setTagFilter(TagFilterTypeInputObject $tagFilterTypeInputObject)
    {
        $this->tag_filter = $tagFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
