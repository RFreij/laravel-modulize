<?php

namespace LaravelModulize\Support;

use Illuminate\Support\Str;

class Entity
{
    public static function getClassName($name)
    {
        return Str::contains($name, '/')
            ? array_reverse(explode('/', $name, 2))[0]
            : $name;
    }

    public static function getClassNamespace($name)
    {
        return Str::contains($name, '/')
            ? self::convertPathToNamespace($name)
            : '';
    }

    public static function convertPathToNamespace($name)
    {
        return Str::contains($name, '/')
            ? Str::start(
                str_replace('/', '', self::getPathBeforeClassName($name)),
                '\\'
            )
            : '';

    }

    public static function getPathBeforeClassName($name)
    {
        return Str::before($name, self::getClassName($name));
    }
}
