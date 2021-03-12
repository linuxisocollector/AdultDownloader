<?php

namespace GraphQL\SchemaObject;

class RootFindSceneByHashArgumentsObject extends ArgumentsObject
{
    protected $input;

    public function setInput(SceneHashInputInputObject $sceneHashInputInputObject)
    {
        $this->input = $sceneHashInputInputObject;

        return $this;
    }
}
