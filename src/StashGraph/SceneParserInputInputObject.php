<?php

namespace GraphQL\SchemaObject;

class SceneParserInputInputObject extends InputObject
{
    protected $ignoreWords;
    protected $whitespaceCharacters;
    protected $capitalizeTitle;

    public function setIgnoreWords(array $ignoreWords)
    {
        $this->ignoreWords = $ignoreWords;

        return $this;
    }

    public function setWhitespaceCharacters($whitespaceCharacters)
    {
        $this->whitespaceCharacters = $whitespaceCharacters;

        return $this;
    }

    public function setCapitalizeTitle($capitalizeTitle)
    {
        $this->capitalizeTitle = $capitalizeTitle;

        return $this;
    }
}
