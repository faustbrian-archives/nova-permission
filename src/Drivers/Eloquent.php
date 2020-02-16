<?php

namespace KodeKeep\NovaPermission\Drivers;

use Illuminate\Support\Str;

class Eloquent extends AbstractDriver
{
    /**
     * Get permissions with grouping.
     *
     * @return array
     */
    public static function group(): array
    {
        return app(config('permission.models.permission'))
            ->get()
            ->map(function ($permission) {
                return [
                    'group'  => Str::title($permission->group),
                    'option' => $permission->name,
                    'label'  => $permission->name,
                ];
            })
            ->groupBy('group')
            ->toArray();
    }
}
