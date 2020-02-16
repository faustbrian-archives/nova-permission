<?php

namespace KodeKeep\NovaPermission\Drivers;

abstract class AbstractDriver
{
    /**
     * Get permissions without grouping.
     *
     * @return array
     */
    public static function get(): array
    {
        return app(config('permission.models.permission'))
            ->pluck('name')
            ->toArray();
    }

    /**
     * Get permissions with grouping.
     *
     * @return array
     */
    abstract public static function group(): array;
}
