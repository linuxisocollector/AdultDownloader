<?php

namespace GraphQL\SchemaObject;

class CriterionModifierEnumObject extends EnumObject
{
    const EQUALS = "EQUALS";
    const NOT_EQUALS = "NOT_EQUALS";
    const GREATER_THAN = "GREATER_THAN";
    const LESS_THAN = "LESS_THAN";
    const IS_NULL = "IS_NULL";
    const NOT_NULL = "NOT_NULL";
    const INCLUDES_ALL = "INCLUDES_ALL";
    const INCLUDES = "INCLUDES";
    const EXCLUDES = "EXCLUDES";
    const MATCHES_REGEX = "MATCHES_REGEX";
    const NOT_MATCHES_REGEX = "NOT_MATCHES_REGEX";
}
