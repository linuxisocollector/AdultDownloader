<?php

namespace GraphQL\SchemaObject;

class ScraperQueryObject extends QueryObject
{
    const OBJECT_NAME = "Scraper";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectPerformer(ScraperPerformerArgumentsObject $argsObject = null)
    {
        $object = new ScraperSpecQueryObject("performer");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScene(ScraperSceneArgumentsObject $argsObject = null)
    {
        $object = new ScraperSpecQueryObject("scene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectGallery(ScraperGalleryArgumentsObject $argsObject = null)
    {
        $object = new ScraperSpecQueryObject("gallery");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectMovie(ScraperMovieArgumentsObject $argsObject = null)
    {
        $object = new ScraperSpecQueryObject("movie");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
