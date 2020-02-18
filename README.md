# Laravel Nova - Permission

[![Latest Version](https://badgen.net/packagist/v/kodekeep/nova-permission)](https://packagist.org/packages/kodekeep/nova-permission)
[![Software License](https://badgen.net/packagist/license/kodekeep/nova-permission)](https://packagist.org/packages/kodekeep/nova-permission)
[![Build Status](https://img.shields.io/github/workflow/status/kodekeep/nova-permission/run-tests?label=tests)](https://github.com/kodekeep/nova-permission/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Coverage Status](https://badgen.net/codeclimate/coverage/kodekeep/nova-permission)](https://codeclimate.com/github/kodekeep/nova-permission)
[![Quality Score](https://badgen.net/codeclimate/maintainability/kodekeep/nova-permission)](https://codeclimate.com/github/kodekeep/nova-permission)
[![Total Downloads](https://badgen.net/packagist/dt/kodekeep/nova-permission)](https://packagist.org/packages/kodekeep/nova-permission)

This package was created by, and is maintained by [Brian Faust](https://github.com/faustbrian), and provides a Laravel Nova resource tool for spatie/laravel-permission.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require kodekeep/nova-permission
```

Next you'll need to register the tool with Nova. This is done in the `tools` method of the `NovaServiceProvider`.

```php
<?php

namespace App\Providers;

use KodeKeep\NovaPermission\NovaPermissionTool;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    // ...

    public function tools()
    {
        return [
            (new NovaPermissionTool())->canSee(function ($request) {
                return $request->user()->hasRole('super-admin');
            }),
        ];
    }

    // ...
}
```

Next you'll need to add the middleware to the `middleware` list in `config/nova.php`.

```php
<?php

return [

    // ...

    'middleware' => [
        'web',
        Authenticate::class,
        DispatchServingNovaEvent::class,
        BootTools::class,
        Authorize::class,
        // ...
        \KodeKeep\NovaPermission\ForgetCachedPermissions::class,
    ],

    // ...

];
```

## Usage

The `KodeKeep\NovaPermission\Fields\Permissions` field can be used with any model that uses the `Spatie\Permission\Traits\HasRoles` trait.

It will automatically load permissions from a model that uses this trait and render them inside the Nova UI based on your configured preferences.

### Preparing your `User` model and resource

If you wish to manage permissions directly on a user resource you will have to apply the same code to the `User` model as you did to the `Role` model and then add below code to the fields of your `User` resource.

```php
use KodeKeep\NovaPermission\Fields\Permissions;
use KodeKeep\NovaPermission\Helpers;
use Laravel\Nova\Fields\MorphToMany;

Permissions::make('Permissions'),

MorphToMany::make('Permissions', 'permissions', \KodeKeep\NovaPermission\Resources\Permission::class),
```

## Drivers

### `KodeKeep\NovaPermission\Drivers\Name` (Default)

> Used with `Permissions::make('Permissions')->fromNameWithGroup()` and `Permissions::make('Permissions')->fromNameWithoutGroup()`.

The `Name` driver will determine the group based on the name of the permission.

If you have a permission called `view posts` it will assume that `posts` is the group of the permission.

### `KodeKeep\NovaPermission\Drivers\Eloquent`

> Used with `Permissions::make('Permissions')->fromEloquentWithGroup()` and `Permissions::make('Permissions')->fromEloquentWithoutGroup()`.

The `Eloquent` driver will determine the group based on `group` attribute of the model.

#### Preparing the `permissions` table

```
php artisan make:migration add_group_to_permissions_table --table=permissions
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@kodekeep.com. All security vulnerabilities will be promptly addressed.

## Credits

This project exists thanks to all the people who [contribute](../../contributors).

## Support Us

We invest a lot of resources into creating and maintaining our packages. You can support us and the development through [GitHub Sponsors](https://github.com/sponsors/faustbrian).

## License

Nova Permission is an open-sourced software licensed under the [MPL-2.0](LICENSE.md).
