<?php

namespace GraphQL\SchemaObject;

class ScenePathsTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScenePathsType";

    public function selectScreenshot()
    {
        $this->selectField("screenshot");

        return $this;
    }

    public function selectPreview()
    {
        $this->selectField("preview");

        return $this;
    }

    public function selectStream()
    {
        $this->selectField("stream");

        return $this;
    }

    public function selectWebp()
    {
        $this->selectField("webp");

        return $this;
    }

    public function selectVtt()
    {
        $this->selectField("vtt");

        return $this;
    }

    public function selectChaptersVtt()
    {
        $this->selectField("chapters_vtt");

        return $this;
    }
}
