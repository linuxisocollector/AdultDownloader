<?php

namespace GraphQL\SchemaObject;

class LogEntryQueryObject extends QueryObject
{
    const OBJECT_NAME = "LogEntry";

    public function selectTime()
    {
        $this->selectField("time");

        return $this;
    }

    public function selectLevel()
    {
        $this->selectField("level");

        return $this;
    }

    public function selectMessage()
    {
        $this->selectField("message");

        return $this;
    }
}
