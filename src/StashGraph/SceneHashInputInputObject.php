<?php

namespace GraphQL\SchemaObject;

class SceneHashInputInputObject extends InputObject
{
    protected $checksum;
    protected $oshash;

    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;

        return $this;
    }

    public function setOshash($oshash)
    {
        $this->oshash = $oshash;

        return $this;
    }
}
