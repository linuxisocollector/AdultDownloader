<?php

namespace GraphQL\SchemaObject;

class ConfigInterfaceResultQueryObject extends QueryObject
{
    const OBJECT_NAME = "ConfigInterfaceResult";

    public function selectMenuItems()
    {
        $this->selectField("menuItems");

        return $this;
    }

    public function selectSoundOnPreview()
    {
        $this->selectField("soundOnPreview");

        return $this;
    }

    public function selectWallShowTitle()
    {
        $this->selectField("wallShowTitle");

        return $this;
    }

    public function selectWallPlayback()
    {
        $this->selectField("wallPlayback");

        return $this;
    }

    public function selectMaximumLoopDuration()
    {
        $this->selectField("maximumLoopDuration");

        return $this;
    }

    public function selectAutostartVideo()
    {
        $this->selectField("autostartVideo");

        return $this;
    }

    public function selectShowStudioAsText()
    {
        $this->selectField("showStudioAsText");

        return $this;
    }

    public function selectCss()
    {
        $this->selectField("css");

        return $this;
    }

    public function selectCssEnabled()
    {
        $this->selectField("cssEnabled");

        return $this;
    }

    public function selectLanguage()
    {
        $this->selectField("language");

        return $this;
    }
}
