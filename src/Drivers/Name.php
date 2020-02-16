<?php

namespace KodeKeep\NovaPermission\Drivers;

use Illuminate\Support\Str;

class Name extends AbstractDriver
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
                $parts = explode(' ', str_replace('-', ' ', $permission->name));

                return [
                    'group'  => Str::title(collect($parts)->slice(1)->implode(' ')),
                    'option' => $permission->name,
                    'label'  => $permission->name,
                ];
            })
            ->groupBy('group')
            ->toArray();
    }
}
