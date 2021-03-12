<?php

namespace GraphQL\SchemaObject;

class SceneFileTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneFileType";

    public function selectSize()
    {
        $this->selectField("size");

        return $this;
    }

    public function selectDuration()
    {
        $this->selectField("duration");

        return $this;
    }

    public function selectVideoCodec()
    {
        $this->selectField("video_codec");

        return $this;
    }

    public function selectAudioCodec()
    {
        $this->selectField("audio_codec");

        return $this;
    }

    public function selectWidth()
    {
        $this->selectField("width");

        return $this;
    }

    public function selectHeight()
    {
        $this->selectField("height");

        return $this;
    }

    public function selectFramerate()
    {
        $this->selectField("framerate");

        return $this;
    }

    public function selectBitrate()
    {
        $this->selectField("bitrate");

        return $this;
    }
}
