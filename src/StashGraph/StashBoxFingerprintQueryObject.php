<?php

namespace GraphQL\SchemaObject;

class StashBoxFingerprintQueryObject extends QueryObject
{
    const OBJECT_NAME = "StashBoxFingerprint";

    public function selectAlgorithm()
    {
        $this->selectField("algorithm");

        return $this;
    }

    public function selectHash()
    {
        $this->selectField("hash");

        return $this;
    }

    public function selectDuration()
    {
        $this->selectField("duration");

        return $this;
    }
}
